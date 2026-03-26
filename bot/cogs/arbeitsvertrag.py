
import discord
import yaml
from async_timeout import timeout
from discord.ext import commands
from discord import app_commands
from discord import ButtonStyle
from discord.ui import View, Modal, TextInput, Select
import os
import requests
import asyncio
import urllib
import io
from io import BytesIO

from utils import color_from_interaction


class unterschriftButton(discord.ui.View):
    def __init__(self, name:str, arbeitsverhaltnis:str, einstellung:str, rang:str, verwalter:str, position:str):
        super().__init__(timeout=None)
        self.name = name
        self.arbeitsverhaltnis = arbeitsverhaltnis
        self.einstellung = einstellung
        self.rang = rang
        self.verwalter = verwalter
        self.position = position

    @discord.ui.button(label='Unterschreiben', style=discord.ButtonStyle.primary, custom_id='unterschrift')
    async def callback(self, interaction: discord.Interaction, button: discord.ui.Button):
        try:
            await interaction.response.defer(ephemeral=True)
            button.disabled = True
            await interaction.message.edit(view=self)
            base_url = "https://krd.nuscheltech.de/intranet/create/arbeitsvertrag"
            params = {
                "name": self.name,
                "arbeitsverhaltnis": self.arbeitsverhaltnis,
                "einstellung": self.einstellung,
                "rang": self.rang,
                "verwalter": self.verwalter,
                "user_id": interaction.user.id,
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

            await interaction.followup.send("Dein Vertrag:", file=file)

        except Exception as e:
            print(e)



class vertrag(commands.Cog):
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

    @app_commands.command(name="vertrag", description="Generiert und sendet einen Arbeitsvertrag als PDF")
    @app_commands.describe(
        name="Name des Mitarbeiters",
        user='Discord User',
        arbeitsverhaltnis="z. B. Vollzeit oder Ehrenamt",
        einstellung="Einstellungsdatum (z. B. 20.04.2025)",
        rang="Dienstgrad (z. B. NFS) falls leer n.A. schreiben",
        verwalter="Name des Verwalters",
    )
    @app_commands.choices(
        arbeitsverhaltnis=[
            app_commands.Choice(name='Vollzeit', value='Vollzeit'),
            app_commands.Choice(name='Ehrenamt', value='Ehrenamt')
        ]
    )
    @app_commands.choices(
        rang=[
            app_commands.Choice(name='Auszubildender', value='Auszubildender'),
            app_commands.Choice(name='Rettungshelfer', value='Rettungshelfer'),
            app_commands.Choice(name='Rettungssanitäter', value='Rettungssanitäter'),
            app_commands.Choice(name='Notfallsanitäter', value='Notfallsanitäter'),
            app_commands.Choice(name='Notarzt', value='Notarzt'),
            app_commands.Choice(name='Höherer Dienst', value='Höherer Dienst'),
            app_commands.Choice(name='Ehrenamt', value='Ehrenamt'),
        ]
    )
    async def vertrag(
            self,
            interaction: discord.Interaction,
            user: discord.User,
            name: str,
            arbeitsverhaltnis: str,
            einstellung: str,
            rang: str,
            verwalter: str,
    ):

        for i in interaction.user.roles:
            if i.id == 1440291817332674601 or i.id == 1440287614484746362 or interaction.user.id == 722885944969134211:

                await interaction.response.defer(ephemeral=True)

                base_url = "https://krd.nuscheltech.de/intranet/create/arbeitsvertragohne"
                params = {
                    "name": name,
                    "arbeitsverhaltnis": arbeitsverhaltnis,
                    "einstellung": einstellung,
                    "rang": rang,
                    "verwalter": verwalter
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
                position = '1'
                try:
                    await user.send('Das Dokument wurde ohne Unterschrift erstellt. Bitte prüfen und unterschreiben Sie das Dokument.', file=file, view=unterschriftButton(name, arbeitsverhaltnis, einstellung, rang, verwalter, position))

                    channel = self.bot.get_channel(1447619250045976676)

                    embed = discord.Embed(title='Eine Arbeitsvertrage wurde ausgestellt!', description='', color=color_from_interaction(interaction.id))
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
            if i.id == 1440291817332674601 or i.id == 1440287614484746362 or interaction.user.id == 722885944969134211:

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

    await bot.add_cog(vertrag(bot))
