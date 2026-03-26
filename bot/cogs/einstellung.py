import os
import discord
from async_timeout import timeout
from discord.ext import commands
from discord import app_commands
from discord import ButtonStyle
import requests
import urllib
from io import BytesIO
from typing import Optional
from utils import color_from_interaction




class unterschriftButton(discord.ui.View):
    def __init__(self, name:str, arbeitsverhaltnis:str, arbeitsbeginn:str, rang:str, verwalter:str, position:str, geschlecht: str, geburtsdatum:str, telefonnummer:int, iban:str, verwalter_user: discord.User, user: discord.User, bot: commands.Bot):
        super().__init__(timeout=None)
        self.name = name
        self.arbeitsverhaltnis = arbeitsverhaltnis
        self.arbeitsbeginn = arbeitsbeginn
        self.rang = rang
        self.verwalter = verwalter
        self.position = position
        self.geschlecht = geschlecht
        self.geburtsdatum = geburtsdatum
        self.telefonnummer = telefonnummer
        self.iban = iban
        self.verwalter_user = verwalter_user
        self.user = user
        self.bot = bot

    @discord.ui.button(label='Unterschreiben', style=discord.ButtonStyle.primary, custom_id='unterschrift')
    async def callback(self, interaction: discord.Interaction, button: discord.ui.Button):
        try:
            await interaction.response.defer(ephemeral=True)
            button.disabled = True
            await interaction.message.edit(view=self)
            base_url = "https://krd.nuscheltech.de/intranet/create/einstellung"
            params = {
                "name": self.name,
                "arbeitsverhaltnis": self.arbeitsverhaltnis,
                "einstellung": self.arbeitsbeginn,
                "rang": self.rang,
                "verwalter": self.verwalter,
                "user_id": interaction.user.id,
                "position": self.position,
                "geschlecht": self.geschlecht,
                "geburtsdatum": self.geburtsdatum,
                "telefonnummer": self.telefonnummer,
                "iban": self.iban
            }
            query = urllib.parse.urlencode(params)
            api_url = f"{base_url}?{query}"

            headers = {
                "X-API-Key": os.getenv("INTRANET_API_KEY", "")
            }
            response = requests.get(api_url, headers=headers)

            data = response.json()
            pdf_url = data.get("message")
            pdf_response = requests.get(pdf_url)
            print(data.get("rang"))

            file = discord.File(BytesIO(pdf_response.content), filename="arbeitsvertrag.pdf")
            file2 = discord.File(BytesIO(pdf_response.content), filename="arbeitsvertrag.pdf")



            try:
                await self.verwalter_user.send('Das Dokument wurde unterschrieben.', file=file2)
                guild = self.bot.get_guild(1058946637113864232)
                member = guild.get_member(self.user.id)
                role = guild.get_role(data.get("rang")["discord_id"])
                if data.get("rang")["discord_id"] == 1058954026105966652 or data.get("rang")["discord_id"] == 1058955109926719549 or data.get("rang")["discord_id"] == 1066362909590028370 or data.get("rang")["discord_id"] == 1066466640293802044:
                    await member.add_roles(role)
                    await member.add_roles(guild.get_role(1235641868629311488))
                    await member.add_roles(guild.get_role(1058947129130877010))
                    await member.add_roles(guild.get_role(1059128304583593984))
                elif data.get("rang")["discord_id"] == 1315373002392735824 or data.get("rang")["discord_id"] == 1315372898659209256:
                    await member.add_roles(role)
                    await member.add_roles(guild.get_role(1315372768082133033))
                    await member.add_roles(guild.get_role(1058947129130877010))
                else:
                    await member.add_roles(role)
                    await member.add_roles(guild.get_role(1066375628116463676))
                    await member.add_roles(guild.get_role(1235641868629311488)) 
                    await member.add_roles(guild.get_role(1058947129130877010))
                    await member.add_roles(guild.get_role(1058955431709515776))
                    await member.add_roles(guild.get_role(1058947129130877010))
                    await member.add_roles(guild.get_role(1235636413660270644))
                    await member.add_roles(guild.get_role(1235637551163773078))
                    await member.add_roles(guild.get_role(1113768797208326144))

                    if data.get("rang")["discord_id"] == 1060708128401932430:
                        await member.add_roles(guild.get_role(1066466640293802044)) 
                        await member.add_roles(guild.get_role(1235637601415987304))
                await member.add_roles(guild.get_role(1158092044816883813))
                await member.add_roles(guild.get_role(1237027936129781861))
                await member.add_roles(guild.get_role(1195811784548962365))
                await member.add_roles(guild.get_role(1245736090447511562))
                await member.add_roles(guild.get_role(1298657920879427656))
                
                if len(str(data.get("dienstnummer"))) == 2:
                    await member.edit(nick=f'[BF-0{str(data.get("dienstnummer"))}] {self.name}')
                else:
                    await member.edit(nick=f'[BF-{str(data.get("dienstnummer"))}] {self.name}')
                channek = self.bot.get_channel(1215117618047090718)
                await channek.send(f'[BF-{str(data.get("dienstnummer"))}] {self.name}')
                await interaction.followup.send("Dein Vertrag:", file=file)
            except Exception as e:
                await interaction.followup.send(f'{e}')

        except Exception as e:
            print(e)



class einstellung(commands.Cog):
    def __init__(self, bot):
        self.bot = bot

    
    async def raenge(
        self, interaction: discord.Interaction, current: str
    ) -> list[app_commands.Choice[str]]:
        base_url = "https://krd.nuscheltech.de/intranet/get/raenge"

        api_url = f"{base_url}"

        headers = {
            "X-API-Key": os.getenv("INTRANET_API_KEY", "")
        }
        response = requests.get(api_url, headers=headers)
        data = response.json()
        raenge = data.get("raenge")

        choices = [
            app_commands.Choice(name=rang["name"], value=str(rang["id"]))
            for rang in raenge
            if current.lower() in rang["name"].lower()
        ]

        return choices[:25]

    
    @app_commands.command(name="einstellung", description="Stellt einen Mitarbeiter ein")
    @app_commands.choices(
        arbeitsverhaltnis=[
            app_commands.Choice(name="Vollzeit", value="Vollzeit"),
            app_commands.Choice(name="Ehrenamt", value="Ehrenamt"),
        ]
    )
    @app_commands.choices(
        geschlecht=[
            app_commands.Choice(name="Männlich", value="Männlich"),
            app_commands.Choice(name="Weiblich", value="Weiblich"),
        ]
    )
    @app_commands.autocomplete(rang=raenge)
    @app_commands.choices(
        position = [
            app_commands.Choice(name="Verwalter", value="Verwalter"),
            app_commands.Choice(name="Verwalterin", value="Verwalterin"),
            app_commands.Choice(name="Verwaltungsleiter", value="Verwaltungsleiter"),
            app_commands.Choice(name="Stv. Verwaltungsleiter", value="Stv. Verwaltungsleiter"),
            app_commands.Choice(name="Branddirektor", value="Branddirektor"),
            app_commands.Choice(name="Leitender Branddirektor", value="Leitender Branddirektor"),
            app_commands.Choice(name="Ärztlicher Leiter Rettungsdienst", value="Ärztlicher Leiter Rettungsdienst"),
            app_commands.Choice(name="Stv. Ärztlicher Leiter Rettungsdienst", value="Stv. Ärztlicher Leiter Rettungsdienst"),
            app_commands.Choice(name="Direktor der Berufsfeuerwehr", value="Direktor der Berufsfeuerwehr"),
        ]
    )
    async def einstellung(self, interaction: discord.Interaction, user: discord.Member, name: str, geschlecht:str, arbeitsbeginn: str, arbeitsverhaltnis: str, rang: str, verwalter: str, position: str, geburtsdatum: Optional[str] = "n.a.", telefonnummer: Optional[int] = 1, iban: Optional[str] = "n.a."):
        for i in interaction.user.roles:
            if i.id == 1440287614484746362 or i.id == 1440291817332674601 or interaction.user.id == 722885944969134211:

                await interaction.response.defer(ephemeral=True)

                base_url = "https://krd.nuscheltech.de/intranet/create/arbeitsvertragohne"
                params = {
                    "name": name,
                    "arbeitsverhaltnis": arbeitsverhaltnis,
                    "einstellung": arbeitsbeginn,
                    "rang": rang,
                    "verwalter": verwalter,
                    "position": position
                }
                query = urllib.parse.urlencode(params)
                api_url = f"{base_url}?{query}"

                headers = {
                    "X-API-Key": os.getenv("INTRANET_API_KEY", "")
                }
                response = requests.get(api_url, headers=headers)

                data = response.json()
                pdf_url = data.get("message")
                pdf_response = requests.get(pdf_url)

                file = discord.File(BytesIO(pdf_response.content), filename="arbeitsvertrag.pdf")

                try:
                    await user.send('Das Dokument wurde ohne Unterschrift erstellt. Bitte prüfen und unterschreiben Sie das Dokument.', file=file, view=unterschriftButton(name, arbeitsverhaltnis, arbeitsbeginn, rang, verwalter, position, geschlecht, geburtsdatum, telefonnummer, iban, interaction.user, user, self.bot))
                    channel = self.bot.get_channel(1447619250045976676)

                    embed = discord.Embed(title='Eine Einstellung wurde durchgeführt!', description='',color=color_from_interaction(interaction.id))
                    embed.add_field(name='Verwalter:', value=interaction.user.mention, inline=False)
                    embed.add_field(name='User:', value=user.mention)
                    embed.set_footer(text='Made by @eri_side')
                    await channel.send(embed=embed)
                    await interaction.followup.send('Dokument wurde zur Unterschrift abgeschickt.',ephemeral=True)
                except discord.Forbidden:
                    await interaction.followup.send('Konnte dem User keine DM schicken.',ephemeral=True)
                except Exception as e:
                    await interaction.followup.send(f'{e}')


    @app_commands.command(name="freiedn", description="Freie Dienstnummer")
    async def freieDN(self, interaction: discord.Interaction):
        for i in interaction.user.roles:
            if i.id == 1440287614484746362 or i.id == 1440291817332674601 or interaction.user.id == 722885944969134211:

                await interaction.response.defer(ephemeral=True)

                base_url = "https://krd.nuscheltech.de/intranet/get/freie_dienstnummer"

                api_url = f"{base_url}"

                headers = {
                    "X-API-Key": os.getenv("INTRANET_API_KEY", "")
                }
                response = requests.get(api_url, headers=headers)
                data = response.json()
                dienstnummer = data.get("dienstnummer")
                await interaction.followup.send(f"Die nächste freie Dienstnummer ist: {dienstnummer}", ephemeral=True)


async def setup(bot):

    await bot.add_cog(einstellung(bot))
