
import discord
import yaml
from discord.ext import commands
from discord import app_commands
from discord import ButtonStyle
from discord.ui import View, Modal, TextInput, Select
import os


def has_required_role(user: discord.Member) -> bool:
    with open("data.yaml", "r", encoding="utf-8") as file:
        data = yaml.safe_load(file)
    return any(role.id in data.get("admin_roles") for role in user.roles)

class TicketDropdown(Select):
    def __init__(self, options, bot):
        self.bot = bot
        dropdown_options = [
            discord.SelectOption(label=opt["label"], value=opt["value"], description=opt["description"])
            for opt in options
        ]
        super().__init__(placeholder="Wähle eine Ticket-Kategorie...", options=dropdown_options, custom_id="persistent_dropdown")

    async def callback(self, interaction: discord.Interaction):
        with open("data.yaml", "r", encoding="utf-8") as file:
            data = yaml.safe_load(file)

        options = data.get("dropdown_options", [])
        selected_option = next((opt for opt in options if opt["value"] == self.values[0]), None)

        if not selected_option:
            await interaction.response.send_message("Fehler: Kategorie nicht gefunden!", ephemeral=True)
            return

        modal = TicketModal(selected_option, interaction)
        await interaction.response.send_modal(modal)

class TicketCloseModal(Modal):
    def __init__(self, interaction, author, claimed_by, number):
        self.interaction = interaction
        self.author = author
        self.claimed_by = claimed_by
        self.number= number
        super().__init__(title="Grund", custom_id="reason")

    user_reason = TextInput(label="Gebe einen Grund an:", style=discord.TextStyle.paragraph, placeholder="Was ist der Grund?", required=True, max_length=2000)

    async def on_submit(self, interaction: discord.Interaction):
        with open("data.yaml", "r", encoding="utf-8") as file:
            data = yaml.safe_load(file)

        messages = interaction.channel.history(limit=None)
        html = """<!DOCTYPE html>
                            <html lang="de">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <style>
                                    body { font-family: Arial, sans-serif; background-color: #1E1F22; padding: 0; margin: 0; display: flex; justify-content: center; width: 100%;}
                                    .message-container { width: 85%; margin: 20px 0 20px 0; padding: 30px 20px 0 20px; background: #313338; color: #F2F3F5; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
                                    .message { display: flex; align-items: flex-start; margin-bottom: 10px; }
                                    .avatar { width: 40px; height: 40px; border-radius: 50%; margin-right: 10px; }
                                    .message-content { background: #2B2D31; padding: 14px 14px 14px 14px; border-radius: 6px; max-width: 100%; word-wrap: break-word;}
                                    .username { font-weight: bold; margin-bottom: 5px; }
                                    .timestamp { font-size: 0.8em; color: gray; }
                                    h1 {margin: 0; padding: 0 0 4px 0; font-size: 26px;}
                                    h2 {margin: 0; padding: 20px 0 20px 0; font-size: 18px; color: rgb(175, 175, 175);}
                                    h3 {margin: 0; padding: 0 0 40px 0; font-weight: 300; font-size: 14px; color: rgb(175, 175, 175);}
                                    .message-div {max-width: 80%;}
                                    span {font-size: 11px; color: grey; padding: 0 0 15px 0; margin: 0 0 15px 0;}
                                </style>
                            </head>
                            <body>"""

        html += f"""<div class="message-container">
                                <h1>Ticket-Protokol</h1>
                                <span>Made by @eri_side</span>
                                <h2>{interaction.channel}</h2>
                                <h3>Ticket-ID: {interaction.channel_id}</h3>"""
        nachrichten = []

        async for message in messages:
            nachrichten.append(message)

        for nachricht in reversed(nachrichten):
            html += f"""<div class="message">
                                    <img src="{nachricht.author.avatar}" class="avatar" alt="Avatar">
                                    <div class="message-div">
                                        <div class="username">{nachricht.author}<span class="timestamp">{nachricht.created_at.strftime('%Y-%m-%d %H:%M:%S')}</span></div>
                                        <div class="message-content">{nachricht.content}</div>
                                    </div>
                                </div>"""

        html += "</div></body></html>"
        channel = interaction.guild.get_channel(data.get("log_channel"))

        PARENT_DIR = os.path.abspath(os.path.join(os.path.dirname(__file__), ".."))
        file_path = os.path.join(PARENT_DIR, f"transcript-{interaction.channel.name}.html")

        with open(file_path, "w", encoding="utf-8") as f:
            f.write(html)


        file = discord.File(file_path)
        if self.claimed_by and self.author:
            embed2 = discord.Embed(
                title='Ticket geschlossen!',
            )
            embed2.set_author(name=data.get("embed_title"), icon_url=data.get("embed_logo"))
            embed2.add_field(name='Ticket-Nr:',value=f"{self.number}", inline=True)
            embed2.add_field(name='Ersteller:', value=f"{self.author.mention}", inline=True)
            embed2.add_field(name='Angenommen von:', value=f"{self.claimed_by.mention}", inline=True)
            embed2.add_field(name='Ticket Name:', value=f"{interaction.channel}", inline=True)
            embed2.add_field(name='Erstellt am:', value=f"{interaction.channel.created_at.strftime('%d.%m.%Y %H:%M:%S')}", inline=True)
            embed2.add_field(name='Schließgrund:', value=f"{self.user_reason}", inline=True)
            embed2.set_image(url=data.get("embed_misc_image"))
            embed2.set_footer(text="Made with ❤️ by @eri_side")
            await channel.send(file=file, embed=embed2)
        else:
            embed2 = discord.Embed(
                title='Ticket geschlossen!',
            )
            embed2.set_author(name=data.get("embed_title"), icon_url=data.get("embed_logo"))
            embed2.add_field(name='Ticket-Nr:', value=f"{self.number}", inline=True)
            embed2.add_field(name='Ersteller:', value=f"{self.author.mention}", inline=True)
            embed2.add_field(name='Angenommen von:', value=f"Niemand", inline=True)
            embed2.add_field(name='Ticket Name:', value=f"{interaction.channel}", inline=True)
            embed2.add_field(name='Erstellt am:',
                             value=f"{interaction.channel.created_at.strftime('%d.%m.%Y %H:%M:%S')}", inline=True)
            embed2.add_field(name='Schließgrund:', value=f"{self.user_reason}", inline=True)
            embed2.set_image(url=data.get("embed_misc_image"))
            embed2.set_footer(text="Made with ❤️ by @eri_side")
            await channel.send(file=file, embed=embed2)
        os.remove(file_path)


        await interaction.response.send_message("Ticket wird geschlossen...", ephemeral=True)

        await interaction.channel.delete()

class ButtonView(discord.ui.View):
    def __init__(self, author: discord.Member=None, number=None):
        super().__init__(timeout=None)
        self.ticket_author = author
        self.claimed_by = None
        self.number = number

    @discord.ui.button(label='Ticket Claimen', style=ButtonStyle.grey, custom_id="persistent_button1")
    async def claim(self, interaction: discord.Interaction, button: discord.ui.Button):
        with open("data.yaml", "r", encoding="utf-8") as file:
            data = yaml.safe_load(file)

        with open("tickets.yaml", "r", encoding="utf-8") as file:
            tickets_data = yaml.safe_load(file)
            if tickets_data is None:
                tickets_data = {"claimed_tickets": {}}


        ticket_data = tickets_data["claimed_tickets"][str(interaction.channel.id)]
        try:
            print(ticket_data.get("claimer_id"))
        except Exception as e:
            print(e)

        if ticket_data.get("claimer_id") == 0:
            self.claimed_by = None
        else:
            self.claimed_by = interaction.guild.get_member(ticket_data.get("claimer_id"))

        if not has_required_role(interaction.user):

            embed2 = discord.Embed(
                title='Keine Berechtigungen!',
            )
            embed2.set_author(name=data.get("embed_title"), icon_url=data.get("embed_logo"))
            embed2.add_field(name='', value="Du hast nicht genug Berechtigungen dazu", inline=False)
            embed2.set_image(url=data.get("embed_misc_image"))
            embed2.set_footer(text="Made with ❤️ by @eri_side")
            await interaction.response.send_message(embed=embed2, ephemeral=True)
            return

        if self.claimed_by:
            embed2 = discord.Embed(
                title='Bereits geclaimt!',
            )
            embed2.set_author(name=data.get("embed_title"), icon_url=data.get("embed_logo"))
            embed2.add_field(name='', value=f"Ticket wurde bereits von {self.claimed_by.mention} geclaimt!", inline=False)
            embed2.set_image(url=data.get("embed_misc_image"))
            embed2.set_footer(text="Made with ❤️ by @eri_side")
            await interaction.response.send_message(embed=embed2, ephemeral=True)
            return

        self.claimed_by = interaction.user
        tickets_data.setdefault("claimed_tickets", {})[str(interaction.channel.id)] = {
            "claimer_id": interaction.user.id,
            "author_id": self.ticket_author.id
        }

        with open("tickets.yaml", "w", encoding="utf-8") as file:
            yaml.safe_dump(tickets_data, file)


        abteilung_data = next((entry for entry in data.get("dropdown_options", []) if entry["category_id"] == interaction.channel.category.id), None)

        acces_roles= abteilung_data.get("access_roles")
        for role in acces_roles:
            await interaction.channel.set_permissions(interaction.guild.get_role(role), read_messages=True, send_messages=False)

        await interaction.channel.set_permissions(interaction.user, read_messages=True,send_messages=False)
        await interaction.channel.set_permissions(self.ticket_author, read_messages=True,send_messages=False)



        embed2 = discord.Embed(
            title='Ticket geclaimt!',
        )
        embed2.set_author(name=data.get("embed_title"), icon_url=data.get("embed_logo"))
        embed2.add_field(name='', value=f"Ticket wurde von {self.claimed_by.mention} geclaimt!", inline=False)
        embed2.set_image(url=data.get("embed_misc_image"))
        embed2.set_footer(text="Made with ❤️ by @eri_side")
        await interaction.response.send_message(embed=embed2)




    @discord.ui.button(label='Ticket Schließen', style=ButtonStyle.grey, custom_id="persistent_button2")
    async def close(self, interaction: discord.Interaction, button: discord.ui.Button):
        with open("data.yaml", "r", encoding="utf-8") as file:
            data = yaml.safe_load(file)

        if not has_required_role(interaction.user):
            embed2 = discord.Embed(
                title='Keine Berechtigungen!',
            )
            embed2.set_author(name=data.get("embed_title"), icon_url=data.get("embed_logo"))
            embed2.add_field(name='', value="Du hast nicht genug Berechtigungen dazu", inline=False)
            embed2.set_image(url=data.get("embed_misc_image"))
            embed2.set_footer(text="Made with ❤️ by @eri_side")
            await interaction.response.send_message(embed=embed2, ephemeral=True)
            return

        overwrites= interaction.channel.overwrites

        if self.ticket_author in overwrites:
            await interaction.channel.set_permissions(self.ticket_author, overwrite=None)


        embed2 = discord.Embed(
            title='Ticket Geschlossen!',
        )
        embed2.set_author(name=data.get("embed_title"), icon_url=data.get("embed_logo"))
        embed2.add_field(name='', value=f"Ticket wurde von {interaction.user.mention} geschlossen!", inline=False)
        embed2.set_image(url=data.get("embed_misc_image"))
        embed2.set_footer(text="Made with ❤️ by @eri_side")
        modal = TicketCloseModal(interaction, self.ticket_author, self.claimed_by, self.number)
        await interaction.response.send_modal(modal)

class TicketModal(Modal):
    def __init__(self, selected_option, interaction):
        self.selected_option = selected_option
        self.interaction = interaction
        super().__init__(title="Ticket-Erstellung", custom_id="ticket_modal")

    user_problem = TextInput(label="Beschreibe dein Problem:", style=discord.TextStyle.paragraph, placeholder="Was ist das Problem?", required=True, max_length=2000)

    async def on_submit(self, interaction: discord.Interaction):
        with open("data.yaml", "r", encoding="utf-8") as file:
            data = yaml.safe_load(file)

        with open("tickets.yaml", "r", encoding="utf-8") as file:
            tickets_data = yaml.safe_load(file) or {}

        ticket_counter = data.get("ticket_counter", 1)
        category_id = self.selected_option.get("category_id")
        category = interaction.guild.get_channel(category_id)

        if not category or not isinstance(category, discord.CategoryChannel):
            await interaction.response.send_message("Fehler: Kategorie existiert nicht!", ephemeral=True)
            return

        prefix = self.selected_option["value"]
        ticket_name_format = self.selected_option.get("format", "{prefix}-{ticket_number}-{username}")
        ticket_name = ticket_name_format.format(
            prefix=prefix,
            ticket_number=f"{ticket_counter:03d}",
            username=interaction.user.name.lower().replace(' ', '-')
        )

        access_roles = self.selected_option.get("access_roles", [])
        ping_roles = self.selected_option.get("ping_roles", [])

        overwrites = {
            interaction.guild.default_role: discord.PermissionOverwrite(view_channel=False),
            interaction.user: discord.PermissionOverwrite(view_channel=True, send_messages=True, attach_files=True),
            interaction.guild.me: discord.PermissionOverwrite(view_channel=True, send_messages=True)
        }

        for role_id in access_roles:
            role = interaction.guild.get_role(role_id)
            if role:
                overwrites[role] = discord.PermissionOverwrite(view_channel=True, send_messages=True, attach_files=True)

        ticket_channel = await interaction.guild.create_text_channel(
            name=ticket_name,
            category=category,
            overwrites=overwrites
        )

        # Speichere das Ticket mit `claimer_id` auf None
        tickets_data.setdefault("claimed_tickets", {})[str(ticket_channel.id)] = {
            "claimer_id": None,
            "author_id": interaction.user.id,
            "ticket_id": ticket_counter
        }

        with open("tickets.yaml", "w", encoding="utf-8") as file:
            yaml.safe_dump(tickets_data, file)

        data["ticket_counter"] += 1
        with open("data.yaml", "w", encoding="utf-8") as file:
            yaml.safe_dump(data, file)

        ping_mentions = [f"<@&{role_id}>" for role_id in ping_roles]

        embed = discord.Embed(
            title='',
            description=f"# **Neues Ticket: #{ticket_counter}**",
            color=discord.Color.blue()
        )
        embed.set_footer(text="Made with ❤️ by @eri_side")
        embed.set_image(url=data.get("embed_misc_image"))
        embed.set_thumbnail(url=data.get("embed_logo"))
        embed.add_field(name=f'{self.selected_option["label"]}',
                        value=f"<@{interaction.user.id}> hat ein neues Ticket erstellt! Bitte bleib geduldig, unser Support-Team wird sich bald um dein Ticket annehmen!",
                        inline=False)
        embed.add_field(name='', value=f"Beschriebene Details:\n`{self.user_problem.value}`")
        embed.set_author(name=data.get("embed_title"), icon_url=data.get("embed_logo"))

        await ticket_channel.send(
            content=f'<@{interaction.user.id}>' + ''.join(ping_mentions),
            embed=embed,
            view=ButtonView(interaction.user, ticket_counter)
        )

        embed2 = discord.Embed(
            title='Ticket erstellt!',
        )
        embed2.set_author(name=data.get("embed_title"), icon_url=data.get("embed_logo"))
        embed2.add_field(name='', value=f'Ticket Nr: {ticket_counter:03d}', inline=False)
        embed2.add_field(name='', value=f'Abteilung: {self.selected_option["label"]}', inline=False)
        embed2.add_field(name='', value=f'Erstelltes Ticket: <#{ticket_channel.id}>', inline=False)
        embed2.set_image(url=data.get("embed_misc_image"))
        embed2.set_footer(text="Made with ❤️ by @eri_side")

        await interaction.response.send_message(content=f'<@{interaction.user.id}>', embed=embed2, ephemeral=True)

class TicketView(View):
    def __init__(self, options, bot):
        super().__init__(timeout=None)
        self.add_item(TicketDropdown(options, bot))

class TicketCog(commands.Cog):
    def __init__(self, bot):
        self.bot = bot


    async def autocomplete_abteilungen(
        self, interaction: discord.Interaction, current: str
    ) -> list[app_commands.Choice[str]]:
        with open("data.yaml", "r", encoding="utf-8") as file:
            data = yaml.safe_load(file)

        choices = [
            app_commands.Choice(name=entry["label"], value=entry["value"])
            for entry in data.get("dropdown_options", [])
            if current.lower() in entry["label"].lower()
        ]


        return choices[:25]



    @app_commands.command(name="rename", description="Ändere den Ticket Name")
    async def rename(self, interaction: discord.Interaction, name: str):
        with open("data.yaml", "r", encoding="utf-8") as file:
            data = yaml.safe_load(file)
        if not has_required_role(interaction.user):
            await interaction.response.send_message("Du hast keine Berechtigung, diesen Befehl zu verwenden!", ephemeral=True)
            return
        await interaction.channel.edit(name=name)
        embed2 = discord.Embed(
            title='Neuer Name!',
        )
        embed2.set_author(name=data.get("embed_title"), icon_url=data.get("embed_logo"))
        embed2.add_field(name='', value=f"<@{interaction.user.id}> hat das Ticket umbenannt! \nNeuer Name: **{interaction.channel}**", inline=False)
        embed2.set_image(url=data.get("embed_misc_image"))
        embed2.set_footer(text="Made with ❤️ by @eri_side")
        await interaction.response.send_message(embed=embed2)

    @app_commands.command(name="setup_tickets", description="Aktualisiere das Ticket-Embed!")
    async def setup_tickets(self, interaction: discord.Interaction):
        if not has_required_role(interaction.user):
            await interaction.response.send_message("Du hast keine Berechtigung, diesen Befehl zu verwenden!", ephemeral=True)
            return
        with open("data.yaml", "r", encoding="utf-8") as file:
            data = yaml.safe_load(file)


        options = data.get("dropdown_options", [])
        message_id = data.get("message_id")

        view = TicketView(options, self.bot)
        embed = discord.Embed(title='', description=data.get("embed_header"))
        embed.set_author(name= data.get("embed_title"), icon_url=data.get("embed_logo"))
        embed.add_field(name='', value=data.get("embed_text"), inline=False)
        embed.set_thumbnail(url=data.get("embed_thumbnail"))
        embed.set_image(url=data.get("embed_image"))
        embed.set_footer(text="Made with ❤️ by @eri_side")

        if message_id:
            try:
                old_message = await self.bot.get_channel(data.get("channel_id")).fetch_message(message_id)
                await old_message.edit(embed=embed, view=view)
                await interaction.response.send_message("Ticket-Embed aktualisiert!", ephemeral=True)
                return
            except discord.NotFound:
                pass

        message = await self.bot.get_channel(data.get("channel_id")).send(embed=embed, view=view)
        data["message_id"] = message.id

        with open("data.yaml", "w", encoding="utf-8") as file:
            yaml.safe_dump(data, file)

        await interaction.response.send_message("Neues Ticket-Embed wurde gesendet!", ephemeral=True)

    def get_abteilung_data(value: str):
        with open("data.yaml", "r", encoding="utf-8") as file:
            data = yaml.safe_load(file)

        for entry in data.get("dropdown_options", []):
            if entry.get("value") == value:
                return entry

        return None



    @app_commands.command(name="übertragen", description="Übertrage das Ticket an einen anderen Nutzer bzw. Rolle")
    @app_commands.describe(abteilung="Wähle eine Abteilung", reason="Gib einen Grund an")
    @app_commands.autocomplete(abteilung=autocomplete_abteilungen)
    async def uebertragen(self, interaction: discord.Interaction, abteilung: str = None, reason: str = None):

        with open("data.yaml", "r", encoding="utf-8") as file:
            data = yaml.safe_load(file)
        if not has_required_role(interaction.user):
            await interaction.response.send_message("Du hast keine Berechtigung, diesen Befehl zu verwenden!",ephemeral=True)
            return

        if abteilung is None or reason is None:
            await interaction.response.send_message("Gib einen Grund und Abteilung an!", ephemeral=True)

        abteilung_data = next((entry for entry in data.get("dropdown_options", []) if entry["value"] == abteilung), None)
        if not abteilung_data:
            await interaction.response.send_message("Ungültige Abteilung ausgewählt.", ephemeral=True)
            return

        category_id = abteilung_data.get("category_id")
        access_roles = abteilung_data.get("access_roles", [])
        ping_roles = abteilung_data.get("ping_roles")

        ping_mentions = [f"<@&{role_id}>" for role_id in ping_roles]

        category = self.bot.get_channel(category_id)
        for role in access_roles:
            await interaction.channel.set_permissions(interaction.guild.get_role(role), read_messages=True, send_messages=True)


        try:
            data["claimed_tickets"][str(interaction.channel.id)]["claimer_id"] = 0
            with open("tickets.yaml", "w", encoding="utf-8") as file:
                yaml.dump(data, file, default_flow_style=False, allow_unicode=True)
        except Exception as e:
            print(e)


        embed2 = discord.Embed(
            title='Ticket weitergegeben!',
        )
        embed2.set_author(name=data.get("embed_title"), icon_url=data.get("embed_logo"))
        embed2.add_field(name='', value=f'<@{interaction.user.id}> hat das Ticket an {abteilung_data.get("label")} übegeben aus folgendem Grund: \n{reason}',inline=False)
        embed2.set_image(url=data.get("embed_misc_image"))
        embed2.set_footer(text="Made with ❤️ by @eri_side")
        await interaction.channel.send(content=''.join(ping_mentions), embed=embed2)

        await interaction.channel.edit(category=category)
        await interaction.response.send_message('Ticket erfolgreich übergeben!', ephemeral=True)






    @app_commands.command(name="add",description="Füge einen Benutzer oder eine Rolle zum aktuellen Befehl hinzu")
    @app_commands.describe(user="Wähle einen Benutzer", role="Wähle eine Rolle")
    async def add(self, interaction: discord.Interaction, user: discord.Member = None,role: discord.Role = None):

        with open("data.yaml", "r", encoding="utf-8") as file:
            data = yaml.safe_load(file)
        if not has_required_role(interaction.user):
            await interaction.response.send_message("Du hast keine Berechtigung, diesen Befehl zu verwenden!", ephemeral=True)
            return



        if user is None and role is None:
            await interaction.response.send_message("Bitte gib entweder einen Benutzer oder eine Rolle an!", ephemeral=True)
            return

        if user:
            channel = interaction.channel
            overwrite = channel.overwrites_for(user)
            overwrite.read_messages = True
            overwrite.send_messages = True
            await channel.set_permissions(user, overwrite=overwrite)
            embed2 = discord.Embed(
                title='',
            )
            embed2.set_author(name=data.get("embed_title"), icon_url=data.get("embed_logo"))
            embed2.add_field(name='', value=f"{interaction.user.mention} hat {user.mention} zum Ticket hinzugefügt!",
                             inline=False)
            embed2.set_image(url=data.get("embed_misc_image"))
            embed2.set_footer(text="Made with ❤️ by @eri_side")
            await interaction.response.send_message(content=f"{user.mention}", embed=embed2)

        if role:
            channel = interaction.channel
            overwrite = channel.overwrites_for(role)
            overwrite.read_messages = True
            overwrite.send_messages = True
            await channel.set_permissions(role, overwrite=overwrite)
            embed2 = discord.Embed(
                title='',
            )
            embed2.set_author(name=data.get("embed_title"), icon_url=data.get("embed_logo"))
            embed2.add_field(name='', value=f"{interaction.user.mention} hat {role.mention} zum Ticket hinzugefügt!", inline=False)
            embed2.set_image(url=data.get("embed_misc_image"))
            embed2.set_footer(text="Made with ❤️ by @eri_side")
            await interaction.response.send_message(content=f"{role.mention}", embed=embed2)

    @app_commands.command(name="remove", description="Entferne einen Benutzer oder eine Rolle vom aktuellen Befehl")
    @app_commands.describe(user="Wähle einen Benutzer", role="Wähle eine Rolle")
    async def remove(self, interaction: discord.Interaction, user: discord.Member = None, role: discord.Role = None):

        with open("data.yaml", "r", encoding="utf-8") as file:
            data = yaml.safe_load(file)

        if not has_required_role(interaction.user):
            await interaction.response.send_message("Du hast keine Berechtigung, diesen Befehl zu verwenden!",
                                                    ephemeral=True)
            return

        if user is None and role is None:
            await interaction.response.send_message("Bitte gib entweder einen Benutzer oder eine Rolle an!",
                                                    ephemeral=True)
            return

        if user:
            channel = interaction.channel
            overwrite = channel.overwrites_for(user)
            overwrite.read_messages = False  # Entfernt die Leseberechtigung
            overwrite.send_messages = False  # Entfernt die Schreibberechtigung
            await channel.set_permissions(user, overwrite=overwrite)
            embed2 = discord.Embed(
                title='',
            )
            embed2.set_author(name=data.get("embed_title"), icon_url=data.get("embed_logo"))
            embed2.add_field(name='', value=f"{interaction.user.mention} hat {user.mention} aus dem Ticket entfernt!",
                             inline=False)
            embed2.set_image(url=data.get("embed_misc_image"))
            embed2.set_footer(text="Made with ❤️ by @eri_side")
            await interaction.response.send_message(content=f"{user.mention}", embed=embed2)

        if role:
            channel = interaction.channel
            overwrite = channel.overwrites_for(role)
            overwrite.read_messages = False  # Entfernt die Leseberechtigung
            overwrite.send_messages = False  # Entfernt die Schreibberechtigung
            await channel.set_permissions(role, overwrite=overwrite)
            embed2 = discord.Embed(
                title='',
            )
            embed2.set_author(name=data.get("embed_title"), icon_url=data.get("embed_logo"))
            embed2.add_field(name='', value=f"{interaction.user.mention} hat {role.mention} aus dem Ticket entfernt!",
                             inline=False)
            embed2.set_image(url=data.get("embed_misc_image"))
            embed2.set_footer(text="Made with ❤️ by @eri_side")
            await interaction.response.send_message(content=f"{role.mention}", embed=embed2)



    @app_commands.command(name="prio", description="Entferne einen Benutzer oder eine Rolle vom aktuellen Befehl")
    @app_commands.describe(prio="Wähle eine Prioriätat")
    @app_commands.choices(
        prio=[
            app_commands.Choice(name="🔴-Hoch", value="🔴"),
            app_commands.Choice(name="🟡-Mittel", value="🟡"),
            app_commands.Choice(name="🟢-Niedrig", value="🟢"),
        ]
    )
    async def prio(self, interaction: discord.Interaction, prio: str = None):
        with open("data.yaml", "r", encoding="utf-8") as file:
            data = yaml.safe_load(file)

        if not has_required_role(interaction.user):
            await interaction.response.send_message("Du hast keine Berechtigung, diesen Befehl zu verwenden!", ephemeral=True)
            return

        channel = str(interaction.channel.name)

        if channel[0] not in ['🟢', '🟡', '🔴']:
            new_name = f"{prio}-{channel}"
        else:
            new_name = f"{prio}{channel[1:]}"

        await interaction.channel.edit(name=new_name)

        embed = discord.Embed(
            title='',
        )
        embed.set_author(name=data.get("embed_title"), icon_url=data.get("embed_logo"))
        embed.add_field(name='', value=f"Der Kanal hat die Priorität {prio} erhalten!", inline=False)
        embed.set_image(url=data.get("embed_misc_image"))
        embed.set_footer(text="Made with ❤️ by @eri_side")

        await interaction.response.send_message(embed=embed)






async def setup(bot):
    with open("tickets.yaml", "r", encoding="utf-8") as file:
        tickets_data = yaml.safe_load(file) or {}

    with open("data.yaml", "r", encoding="utf-8") as file:
        data = yaml.safe_load(file)

    bot.add_view(TicketView(tickets_data.get("dropdown_options", []), bot))

    claimed_tickets = tickets_data.get("claimed_tickets", {})
    if not isinstance(claimed_tickets, dict):
        claimed_tickets = {}

    for channel_id, ticket_info in claimed_tickets.items():
        guild = bot.get_guild(int(data.get("guild_id")))

        if guild:
            channel = guild.get_channel(int(channel_id))
            claimer = guild.get_member(ticket_info.get("claimer_id"))
            author = guild.get_member(ticket_info.get("author_id"))
            number = ticket_info.get("ticket_id")

            if channel and author:
                view = ButtonView(author=author)
                view.claimed_by = claimer
                view.number = number
                bot.add_view(view)



    await bot.add_cog(TicketCog(bot))
