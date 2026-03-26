import discord
from discord.ext import commands
from discord import app_commands
from discord import ButtonStyle
import requests
import urllib
import PyPDF2
import json
import os

class Buttons(discord.ui.View):
    def __init__(self, ausbildung_id:str, ausbilder:int, name:str):
        super().__init__(timeout=None)
        self.ausbildung = ausbildung_id
        self.ausbilder = ausbilder
        self.name = name

    @discord.ui.button(label='Eintragen', style=ButtonStyle.green, custom_id='eintragen')
    async def eintragen(self, interaction: discord.Interaction, button: discord.ui.Button):
        await interaction.response.send_modal(eintragen(self.ausbildung))

    @discord.ui.button(label='Schließen', style=ButtonStyle.red)
    async def schließen(self, interaction: discord.Interaction, button:discord.ui.Button):
        if interaction.user.id == self.ausbilder:
            await interaction.response.defer(ephemeral = True)
            base_url = "https://krd.nuscheltech.de/landesschule/ausbildungsangebot/close"
            params = {
                "ausbildung_id": self.ausbildung,
                "user_id": interaction.user.id,
            }
            query = urllib.parse.urlencode(params)
            api_url = f"{base_url}?{query}"
            headers = {
                "X-API-Key": os.getenv("INTRANET_API_KEY", "")
            }
            requests.get(url=api_url, headers=headers)
            embed = discord.Embed(title='Ausbildungsangebot')
            embed.add_field(name='Ausbildung', value=self.name, inline=False)
            embed.add_field(name='Status', value='Geschlossen', inline=False)
            embed.add_field(name='Ausbilder', value=f"{interaction.user.mention}", inline=False)
            await interaction.message.edit(embed=embed, view=None)
            await interaction.followup.send('Erfolgreich geschlossen!', ephemeral= True)



class eintragen(discord.ui.Modal):
    def __init__(self, ausbildung:str):
        super().__init__(title='Eintragen')
        self.name = discord.ui.TextInput(label='Name')
        self.geburtsdatum = discord.ui.TextInput(label='Geburtsdatum')
        self.ausbildung = ausbildung
        self.add_item(self.name)
        self.add_item(self.geburtsdatum)

    async def on_submit(self, interaction: discord.Interaction):
        try:
            base_url = "https://krd.nuscheltech.de/landesschule/ausbildungsangebot/adduser"
            params = {
                "ausbildung_id": self.ausbildung,
                "user_id": interaction.user.id,
                "name": self.name,
                "geburtsdatum": self.geburtsdatum
            }
            query = urllib.parse.urlencode(params)
            api_url = f"{base_url}?{query}"
            headers = {
                "X-API-Key": os.getenv("INTRANET_API_KEY", "")
            }
            requests.get(api_url, headers=headers)
            await interaction.response.send_message('Du hast dich erfolgreich eingetragen!', ephemeral=True)
        except Exception as e:
            print(e)

class landesschule(commands.Cog):
    def __init__(self, bot: commands.Bot):
        super().__init__()
        self.bot = bot


    async def raenge(
        self, interaction: discord.Interaction, current: str
    ) -> list[app_commands.Choice[str]]:
        base_url = "https://krd.nuscheltech.de/landesschule/get/ausbildungen"
        params = {
                "user_id" : interaction.user.id
            }
        query = urllib.parse.urlencode(params)
        api_url = f"{base_url}?{query}"

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
    
    @app_commands.command(name='erstelle_ausbildung', description='Erstellt ein Ausbildungsangebot')
    @app_commands.autocomplete(ausbildung=raenge)
    async def erstelle_ausbildung(self, interaction: discord.Interaction, ausbildung: str):
        try:
            for i in interaction.user.roles:
                if i.id == 1332653339623690321 or interaction.user.id == 722885944969134211:
                    await interaction.response.defer(ephemeral=True)
                    headers = {
                        "X-API-Key": os.getenv("INTRANET_API_KEY", "")
                    }
                    params = {
                        "user_id" : interaction.user.id,
                        "ausbildung_id" : int(ausbildung)
                    }
                    query = urllib.parse.urlencode(params)
                    base_url = "https://krd.nuscheltech.de/landesschule/ausbildungsangebot/create"
                    api_url = f"{base_url}?{query}"
                    response = requests.get(api_url, headers=headers)
                    data = response.json()


                    name = data.get('name')

                    channel = self.bot.get_channel(1446904020999471345)
                    embed = discord.Embed(title='Ausbildungsangebot')
                    embed.add_field(name='Ausbildung', value=name, inline=False)
                    embed.add_field(name='Status', value='Offen', inline=False)
                    embed.add_field(name='Ausbilder', value=f"{interaction.user.mention}", inline=False)
                    await channel.send(embed=embed, view=Buttons(data.get('message'), interaction.user.id, name))
                    await interaction.followup.send('Ausbildungsangebot wurde erstellt!', ephemeral=True)
        except Exception as e:
            print(e)


    @app_commands.command(name='zeugnis_einreichen', description='Reiche ein Zeugnis ein')
    async def einreichen(self, interaction:discord.Interaction, file: discord.Attachment):
        try:
            await interaction.response.defer(ephemeral=True)
            filename = file.filename
            
            file_bytes = await file.read()
            with open(f'{filename}', 'wb') as f:
                f.write(file_bytes)
            
            with open(filename, "rb") as file_handle:
                reader = PyPDF2.PdfReader(file_handle)
                metadata = reader.metadata
                anal = json.loads(metadata.get('/Producer'))

            headers = {
                "X-API-Key": os.getenv("INTRANET_API_KEY", "")
            }
            params = {
                "user_id": interaction.user.id,
                **anal
            }
            query = urllib.parse.urlencode(params)
            base_url = "https://krd.nuscheltech.de/landesschule/upload/zeugniss"
            api_url = f"{base_url}?{query}"
            response = requests.get(api_url, headers=headers)
            data = response.json()
            print(data.get('ausbildung'))

            guild = self.bot.get_guild(1058946637113864232)
            user = guild.get_member(interaction.user.id)
            await user.add_roles(guild.get_role(int(data.get('ausbildung')['discordID'])))
            rolleminus = None
            if data.get('ausbildung')['vorher'] != None:
                await user.remove_roles(guild.get_role(int(data.get('ausbildung')['vorher'])))
                rolleminus = guild.get_role(int(data.get('ausbildung')['vorher']))

            channel = self.bot.get_channel(1267136821238829098)
            rolleplus = guild.get_role(int(data.get('ausbildung')['discordID']))
            if rolleminus != None:
                await channel.send(f'{interaction.user.mention} hat ein Dokument eingereicht\nFolgenden Rolle wurde vergeben:{rolleplus.name}\nFolgende wurde entfernt: {rolleminus.name}')
            else:
                await channel.send(f'{interaction.user.mention} hat ein Dokument eingereicht\nFolgenden Rolle wurde vergeben:{rolleplus.name}')
            os.remove(filename)
            await interaction.followup.send('Zeugnis erfolgreich Hinterlegt!', ephemeral=True)
            

        except Exception as e:
            print(e)


            
        


async def setup(bot: commands.Bot):
    await bot.add_cog(landesschule(bot))

