
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
    def __init__(self, name:str, verwalter:str, position:str):
        super().__init__(timeout=None)
        self.name = name
        self.verwalter = verwalter
        self.position = position

    @discord.ui.button(label='Unterschreiben', style=discord.ButtonStyle.primary, custom_id='unterschrift')
    async def callback(self, interaction: discord.Interaction, button: discord.ui.Button):
        try:
            await interaction.response.defer(ephemeral=True)
            button.disabled = True
            await interaction.message.edit(view=self)
            base_url = "https://krd.nuscheltech.de/intranet/create/notarztvertrag"
            params = {
                "name": self.name,
                "verwalter": self.verwalter,
                "user_id": interaction.user.id,
                "position": self.position
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

            file = discord.File(BytesIO(pdf_response.content), filename="notarztvertrag.pdf")

            await interaction.followup.send("Dein Vertrag:", file=file)

        except Exception as e:
            print(e)



class navertrag(commands.Cog):
    def __init__(self, bot):
        self.bot = bot

    

    @app_commands.command(name="notarztvertrag", description="Generiert und sendet einen Notarztvertrag als PDF")
    @app_commands.describe(
        name="Name des Mitarbeiters",
        user='Discord User',
        verwalter="Name des Verwalters",
        position="Verwalter Position"
    )
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
    async def vertrag(
            self,
            interaction: discord.Interaction,
            user: discord.User,
            name: str,
            verwalter: str,
            position:str,
    ):

        for i in interaction.user.roles:
            if i.id == 1440287614484746362 or i.id == 1440291817332674601 or user.id == 722885944969134211:

                await interaction.response.defer(ephemeral=True)

                base_url = "https://krd.nuscheltech.de/intranet/create/notarztvertragohne"
                params = {
                    "name": name,
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

                file = discord.File(BytesIO(pdf_response.content), filename="notarztvertrag.pdf")

                try:
                    await user.send('Das Dokument wurde ohne Unterschrift erstellt. Bitte prüfen und unterschreiben Sie das Dokument.', file=file, view=unterschriftButton(name, verwalter, position))

                    channel = self.bot.get_channel(1447619250045976676)

                    embed = discord.Embed(title='Eine Notarztvertrag wurde ausgestellt!', description='', color=color_from_interaction(interaction.id))
                    embed.add_field(name='Verwalter:', value=interaction.user.mention, inline=False)
                    embed.add_field(name='User:', value=user.mention)
                    embed.set_footer(text='Made by @eri_side')
                    await channel.send(embed=embed)
                    await interaction.followup.send('Dokument wurde zur Unterschrift abgeschickt.',ephemeral=True)
                except discord.Forbidden:
                    await interaction.followup.send('Konnte dem User keine DM schicken.',ephemeral=True)
                except Exception as e:
                    await interaction.followup.send(f'{e}')






async def setup(bot):

    await bot.add_cog(navertrag(bot))
