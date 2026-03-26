import os
import discord
from async_timeout import timeout
from discord.ext import commands
from discord import app_commands
import requests
import urllib
from io import BytesIO





class einstellungkats(commands.Cog):
    def __init__(self, bot):
        self.bot = bot

    

    
    @app_commands.command(name="einstellungkats", description="Stellt einen Mitarbeiter ein")

    @app_commands.choices(
        geschlecht=[
            app_commands.Choice(name="Männlich", value="Männlich"),
            app_commands.Choice(name="Weiblich", value="Weiblich"),
        ]
    )

    async def einstellung(self, interaction: discord.Interaction, user: discord.Member, name: str, vorname: str, geschlecht:str, verwalter: str, geburtsdatum: str, email :str,  telefonnummer: int, iban: str, führerscheinklassen:str, arbeitgeber: str):
        for i in interaction.user.roles:
            if i.id == 1379990676879446106 or interaction.user.id == 722885944969134211:

                await interaction.response.defer(ephemeral=True)

                base_url = "https://krd.nuscheltech.de/intranet/kats/vertrag"
                params = {
                    "name": name,
                    "vorname": vorname,
                    "geburtsdatum": geburtsdatum,
                    "email": email,
                    "verwalter": verwalter,
                    "telefonnummer": telefonnummer,
                    "iban":iban,
                    "geschlecht": geschlecht,
                    "führerscheinklassen": führerscheinklassen,
                    "user_id": user.id,
                    "arbeitgeber": arbeitgeber
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
                    await user.send('Das Dokument erstellt.', file=file)

                    await interaction.followup.send('Mitarbeiter wurde eingestellt und Dokuement verschickt!',ephemeral=True)
                except discord.Forbidden:
                    await interaction.followup.send('Konnte dem User keine DM schicken.',ephemeral=True)
                except Exception as e:
                    await interaction.followup.send(f'{e}')



async def setup(bot):

    await bot.add_cog(einstellungkats(bot))
