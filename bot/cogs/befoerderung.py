import os

import discord
from async_timeout import timeout
from discord.ext import commands
from discord import app_commands
from discord import ButtonStyle
from discord.ui import View, Modal, TextInput, Select
import requests
import urllib
from io import BytesIO
from utils import color_from_interaction



class befoerderung(commands.Cog):
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


    @app_commands.command(name="beförderung", description="Generiert und sendet einen Beförderung als PDF")
    @app_commands.describe(
        user='Discord User',
        rang="Dienstgrad (z. B. Brandmeister-Anwärter)",
        verwalter="Name des Verwalters",
        position="Verwalter Position"
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
    async def bef(
            self,
            interaction: discord.Interaction,
            user: discord.User,
            rang: int,
            verwalter: str,
            position:str,
    ):

        for i in interaction.user.roles:
            if i.id == 1440287614484746362 or i.id == 1440291817332674601 or interaction.user.id == 722885944969134211:

                await interaction.response.defer(ephemeral=True)

                base_url = "https://krd.nuscheltech.de/intranet/create/befoerderung"
                params = {
                    "user_id": user.id,
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

                file = discord.File(BytesIO(pdf_response.content), filename="Befoerderung.pdf")



                baserang_url = "https://krd.nuscheltech.de/intranet/get/raenge"

                apirang_url = f"{baserang_url}"

            
                responserang = requests.get(apirang_url, headers=headers)
                datarang = responserang.json()
                raenge = datarang.get("raenge")


                try:
                    await user.send('', file=file)
                    await interaction.user.send('', file=discord.File(BytesIO(pdf_response.content), filename="Befoerderung.pdf"))
                    await user.remove_roles(discord.Object(id=data.get("old")["discord_id"]))
                    for i in raenge:
                        if i["id"] == rang:
                            await user.add_roles(discord.Object(id=i["discord_id"]))

                    channel = self.bot.get_channel(1447619250045976676)

                    embed = discord.Embed(title='Eine Beförderung wurde ausgestellt!', description='',color=color_from_interaction(interaction.id))
                    embed.add_field(name='Verwalter:', value=interaction.user.mention, inline=False)
                    embed.add_field(name='User:', value=user.mention)
                    embed.set_footer(text='Made by @eri_side')
                    await channel.send(embed=embed)
                    await interaction.followup.send('Dokument wurde abgeschickt.',ephemeral=True)
                except discord.Forbidden:
                    await interaction.followup.send('Konnte dem User keine DM schicken.',ephemeral=True)
                except Exception as e:
                    await interaction.followup.send(f'{e}')

    
    @app_commands.command(name="degradierung", description="Generiert und sendet einen Degradierung als PDF")
    @app_commands.describe(
        user='Discord User',
        rang="Dienstgrad (z. B. Brandmeister-Anwärter)",
        verwalter="Name des Verwalters",
        position="Verwalter Position",
        grund="Grund der Degradierung"
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
    async def deg(
            self,
            interaction: discord.Interaction,
            user: discord.User,
            rang: int,
            verwalter: str,
            position:str,
            grund:str
    ):

        for i in interaction.user.roles:
            if i.id == 1440287614484746362 or i.id == 1440291817332674601 or interaction.user.id == 722885944969134211:

                await interaction.response.defer(ephemeral=True)

                base_url = "https://krd.nuscheltech.de/intranet/create/degradierung"
                params = {
                    "user_id": user.id,
                    "rang": rang,
                    "verwalter": verwalter,
                    "position": position,
                    "grund": grund

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

                file = discord.File(BytesIO(pdf_response.content), filename="Degradierung.pdf")



                baserang_url = "https://krd.nuscheltech.de/intranet/get/raenge"

                apirang_url = f"{baserang_url}"

            
                responserang = requests.get(apirang_url, headers=headers)
                datarang = responserang.json()
                raenge = datarang.get("raenge")


                try:
                    await user.send('', file=file)
                    await interaction.user.send('', file=discord.File(BytesIO(pdf_response.content), filename="Degradierung.pdf"))
                    await user.remove_roles(discord.Object(id=data.get("old")["discord_id"]))
                    for i in raenge:
                        if i["id"] == rang:
                            await user.add_roles(discord.Object(id=i["discord_id"]))

                    channel = self.bot.get_channel(1447619250045976676)

                    embed = discord.Embed(title='Eine Degradierung wurde ausgestellt!', description='',color=color_from_interaction(interaction.id))
                    embed.add_field(name='Verwalter:', value=interaction.user.mention, inline=False)
                    embed.add_field(name='User:', value=user.mention)
                    embed.set_footer(text='Made by @eri_side')
                    await channel.send(embed=embed)
                    await interaction.followup.send('Dokument wurde abgeschickt.',ephemeral=True)
                except discord.Forbidden:
                    await interaction.followup.send('Konnte dem User keine DM schicken.',ephemeral=True)
                except Exception as e:
                    await interaction.followup.send(f'{e}')






async def setup(bot):

    await bot.add_cog(befoerderung(bot))
