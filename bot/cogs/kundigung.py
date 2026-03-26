import discord
from discord.ext import commands
from discord import app_commands
import datetime
import requests
import urllib
from io import BytesIO
import os 
import json
import random
from utils import color_from_interaction
class button(discord.ui.View):
    def __init__(self, user: int, bot: commands.Bot, grund: str, verwalter: str, position: str, law: int, einstellung: str, verwalter_id:int):
        super().__init__(timeout=None)
        self.user = user
        self.bot = bot
        self.grund = grund
        self.verwalter = verwalter
        self.position = position
        self.law = law
        self.einstellung = einstellung
        self.verwalter_id = verwalter_id


    @discord.ui.button(label='Genehmigen', style=discord.ButtonStyle.primary, custom_id='genehmigung')
    async def callback(self, interaction: discord.Interaction, button: discord.ui.Button):
        try:
            await interaction.response.defer(ephemeral=True)
            button.disabled = True
            await interaction.message.edit(view=self)
            base_url = "https://krd.nuscheltech.de/intranet/create/kundigung"
            params = {
                "user_id": self.user,
                "grund": self.grund,
                "einstellung": self.einstellung,
                "verwalter": self.verwalter,
                "position": self.position,
                "law": self.law,
                
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
            file = discord.File(BytesIO(pdf_response.content), filename="kuendigung.pdf")
            anal = await self.bot.fetch_user(self.user)
            await anal.send(file=file)
            verwalter_user = self.bot.get_user(self.verwalter_id)
            await verwalter_user.send(f'Die Kündigung wurde genehmigt und an den Mitarbeiter gesendet.')
            await interaction.followup.send("Die Kündigung wurde genehmigt und an den Mitarbeiter gesendet.", ephemeral=True)
        except Exception as e:
            print(e)

class fristlosebutton(discord.ui.View):
    def __init__(self, user: int, bot: commands.Bot, grund: str, verwalter: str, position: str, law: int, einstellung: str, verwalter_id : int):
        super().__init__(timeout=None)
        self.user = user
        self.bot = bot
        self.grund = grund
        self.verwalter = verwalter
        self.position = position
        self.law = law
        self.einstellung = einstellung
        self.verwalter_id = verwalter_id

    @discord.ui.button(label='Genehmigen', style=discord.ButtonStyle.primary, custom_id='genehmigung')
    async def callback(self, interaction: discord.Interaction, button: discord.ui.Button):
        try:
            await interaction.response.defer(ephemeral=True)
            button.disabled = True
            await interaction.message.edit(view=self)
            base_url = "https://krd.nuscheltech.de/intranet/create/fristloskundigung"
            params = {
                "user_id": self.user,
                "grund": self.grund,
                "einstellung": self.einstellung,
                "verwalter": self.verwalter,
                "position": self.position,
                "law": self.law,
                
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
            file = discord.File(BytesIO(pdf_response.content), filename="kuendigung.pdf")
            anal = await self.bot.fetch_user(self.user)
            await anal.send(file=file)

            verwalter_user = self.bot.get_user(self.verwalter_id)
            await verwalter_user.send(f'Die Kündigung wurde genehmigt und an den Mitarbeiter gesendet.')
            await interaction.followup.send("Die Kündigung wurde genehmigt und an den Mitarbeiter gesendet.", ephemeral=True)
        except Exception as e:
            print(e)


class abmahnungbutton(discord.ui.View):
    def __init__(self, user: int, bot: commands.Bot, grund: str, verwalter: str, position: str, law: int):
        super().__init__(timeout=None)
        self.user = user
        self.bot = bot
        self.grund = grund
        self.verwalter = verwalter
        self.position = position
        self.law = law

    @discord.ui.button(label='Genehmigen', style=discord.ButtonStyle.primary, custom_id='genehmigung')
    async def callback(self, interaction: discord.Interaction, button: discord.ui.Button):
        try:
            await interaction.response.defer(ephemeral=True)
            button.disabled = True
            await interaction.message.edit(view=self)
            base_url = "https://krd.nuscheltech.de/intranet/create/abmahnungohne"
            params = {
                "user_id": self.user,
                "grund": self.grund,
                "verwalter": self.verwalter,
                "position": self.position,
                "law": self.law,
                
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
            file = discord.File(BytesIO(pdf_response.content), filename="abmahnung.pdf")
            anal = await self.bot.fetch_user(self.user)
            embed = discord.Embed(title="Abmahnung", description="", color=discord.Color.from_rgb(255, 0, 0))
            embed.add_field(name="Grund:", inline=True, value=f"{self.grund}")
            await anal.send(file=file, view=abmahnungbuttonunterschrift(self.user, self.bot, self.grund, self.verwalter, self.position, self.law), embed=embed)
            await interaction.followup.send("Die Abmahnung wurde genehmigt und an den Mitarbeiter gesendet.", ephemeral=True)
        except Exception as e:
            print(e)



class abmahnungbuttonunterschrift(discord.ui.View):
    def __init__(self, user: int, bot: commands.Bot, grund: str, verwalter: str, position: str, law: int):
        super().__init__(timeout=None)
        self.user = user
        self.bot = bot
        self.grund = grund
        self.verwalter = verwalter
        self.position = position
        self.law = law

    @discord.ui.button(label='Unterschreiben', style=discord.ButtonStyle.primary, custom_id='genehmigung')
    async def callback(self, interaction: discord.Interaction, button: discord.ui.Button):
        try:
            await interaction.response.defer(ephemeral=True)
            button.disabled = True
            await interaction.message.edit(view=self)
            base_url = "https://krd.nuscheltech.de/intranet/create/abmahnung"
            params = {
                "user_id": self.user,
                "grund": self.grund,
                "verwalter": self.verwalter,
                "position": self.position,
                "law": self.law,
                
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
            file = discord.File(BytesIO(pdf_response.content), filename="abmahnung.pdf")
            await interaction.followup.send(file=file)
        except Exception as e:
            print(e)






class kundigungen(commands.Cog):
    def __init__(self, bot):
        super().__init__()
        self.bot = bot

    async def raenge_autocomplete(self, interaction: discord.Interaction, current: str) -> list[app_commands.Choice[str]]:
        base_url = "https://krd.nuscheltech.de/intranet/get/genehmigung"
        headers = {
            "X-API-Key": os.getenv("INTRANET_API_KEY", "")
        }

        try:
            response = requests.get(base_url, headers=headers)
            data = response.json()
            raenge = data.get("user", [])

            return [
                app_commands.Choice(name=rang[1], value=str(rang[0]))
                for rang in raenge if current.lower() in rang[1].lower()
            ][:25]
        except Exception as e:
            print(f"Error fetching ranks: {e}")
            return []

    @app_commands.command(name="kündigung", description="Kündigung eines Mitarbeiters")     
    @app_commands.choices(
        law=[
            app_commands.Choice(name="nein", value=0),
            app_commands.Choice(name="ja", value=1),
        ]
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
    @app_commands.autocomplete(genehmigt=raenge_autocomplete)
    async def kuendigungs(self, interaction: discord.Interaction, user: discord.User, grund: str, verwalter: str, position: str, law: int, einstellung: str, genehmigt: str):
        try:
            for i in interaction.user.roles:
                if i.id == 1440287614484746362 or i.id == 1440291817332674601 or interaction.user.id == 722885944969134211:
                    await interaction.response.defer(ephemeral=True)
                    if law == 0:
                        lul = "nein"
                    else:
                        lul = "ja"

                    base_url = "https://krd.nuscheltech.de/intranet/create/kundigungohne"
                    params = {
                        "user_id": user.id,
                        "grund": grund,
                        "einstellung": einstellung,
                        "verwalter": verwalter,
                        "position": position,
                        "law": law,
                        
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

                    file = discord.File(BytesIO(pdf_response.content), filename="kuendigung.pdf")

                    useanalr = await self.bot.fetch_user(int(genehmigt))

                    embed = discord.Embed(title="Kündigung wurde erstellt", description="", color=discord.Color.from_rgb(255, 0, 0))
                    embed.add_field(name="Name:", inline=True, value=f"{data.get('name')}")
                    embed.add_field(name="Grund:", inline=True, value=f"{grund}")
                    embed.add_field(name="Rechtliche Schritte:", inline=True, value=f"{lul}")
                    embed.add_field(name="Ersteler:", inline=False, value=f"{verwalter}")
                    await useanalr.send(embed=embed, file=file, view=button(user.id, self.bot, grund, verwalter, position, law, einstellung, interaction.user.id))


                    channel = self.bot.get_channel(1447619250045976676)

                    embed = discord.Embed(title='Eine Kündigung wurde ausgestellt!', description='',color=color_from_interaction(interaction.id))
                    embed.add_field(name='Verwalter:', value=interaction.user.mention, inline=False)
                    embed.add_field(name='User:', value=user.mention)
                    embed.set_footer(text='Made by @eri_side')
                    await channel.send(embed=embed)
                    await interaction.followup.send("Kündigung wurde zur Genehmigung abgeschickt!", ephemeral=True)

        except Exception as e:
            print(e)



    @app_commands.command(name="fristlose_kündigung", description="Fristlose Kündigung eines Mitarbeiters")     
    @app_commands.choices(
        law=[
            app_commands.Choice(name="nein", value=0),
            app_commands.Choice(name="ja", value=1),
        ]
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
    @app_commands.autocomplete(genehmigt=raenge_autocomplete)
    async def kuendigungsf(self, interaction: discord.Interaction, user: discord.User, grund: str, verwalter: str, position: str, law: int, einstellung: str, genehmigt: str):
        try:
            for i in interaction.user.roles:
                if i.id == 1440287614484746362 or i.id == 1440291817332674601 or interaction.user.id == 722885944969134211:
                    await interaction.response.defer(ephemeral=True)
                    if law == 0:
                        lul = "nein"
                    else:
                        lul = "ja"

                    base_url = "https://krd.nuscheltech.de/intranet/create/fristloskundigungohne"
                    params = {
                        "user_id": user.id,
                        "grund": grund,
                        "einstellung": einstellung,
                        "verwalter": verwalter,
                        "position": position,
                        "law": law,
                        
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

                    file = discord.File(BytesIO(pdf_response.content), filename="kuendigung.pdf")

                    useanalr = await self.bot.fetch_user(int(genehmigt))

                    embed = discord.Embed(title="Fristlose Kündigung wurde erstellt", description="", color=discord.Color.from_rgb(255, 0, 0))
                    embed.add_field(name="Name:", inline=True, value=f"{data.get('name')}")
                    embed.add_field(name="Grund:", inline=True, value=f"{grund}")
                    embed.add_field(name="Rechtliche Schritte:", inline=True, value=f"{lul}")
                    embed.add_field(name="Ersteler:", inline=False, value=f"{verwalter}")
                    await useanalr.send(embed=embed, file=file, view=fristlosebutton(user.id, self.bot, grund, verwalter, position, law, einstellung, interaction.user.id))

                    channel = self.bot.get_channel(1447619250045976676)

                    embed = discord.Embed(title='Eine Fristlose Kündigung wurde ausgestellt!', description='',color=color_from_interaction(interaction.id))
                    embed.add_field(name='Verwalter:', value=interaction.user.mention, inline=False)
                    embed.add_field(name='User:', value=user.mention)
                    embed.set_footer(text='Made by @eri_side')
                    await channel.send(embed=embed)
                    await interaction.followup.send("Kündigung wurde zur Genehmigung abgeschickt!", ephemeral=True)

        except Exception as e:
            print(e)
                    
    @app_commands.command(name="kündigungs_bestätigung", description="Bestätigt die Kündigung eines Mitarbeiters")
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
    @app_commands.choices(
        geschlecht=[
            app_commands.Choice(name="Männlich", value="Männlich"),
            app_commands.Choice(name="Weiblich", value="Weiblich"),
        ]
    )
    async def kuendigung(self, interaction: discord.Interaction, geschlecht: str, name: str, verwalter: str, position: str):
        try:
            for i in interaction.user.roles:
                if i.id == 1440287614484746362 or i.id == 1440291817332674601 or interaction.user.id == 722885944969134211:
                    await interaction.response.defer(ephemeral=False)
                    if geschlecht == "Männlich":
                        embed = discord.Embed(title="Eingang der Kündigung", description="", color=discord.Color.from_rgb(255, 0, 0))
                        embed.add_field(name=f"Sehr geehrter Herr {name},",inline=False, value=f"")
                        embed.add_field(name="",inline=False, value=f"Hiermit bestätigen wir den Erhalt Ihrer Kündigung vom **{datetime.date.today().strftime('%d.%m.%Y')}**.")
                        embed.add_field(name="",inline=False, value=f"Wir bedauern es zutiefst, dass Sie sich dazu entschieden haben, die Berufsfeuerwehr zu verlassen.")
                        embed.add_field(name="",inline=False, value=f"Gemäß den vereinbarten Bedingungen endet Ihr Arbeitsverhältnis zum **{(datetime.date.today()+datetime.timedelta(days=14)).strftime('%d.%m.%Y')}**.")
                        embed.add_field(name="",inline=False, value="Bitte beachten Sie, dass bis zu diesem Datum weiterhin alle arbeitsvertraglichen Verpflichtungen und Rechte bestehen.")
                        embed.add_field(name="",inline=False, value="Wir möchten diese Gelegenheit nutzen, um Ihnen für Ihre Mitarbeit und Ihren Einsatz während Ihrer Beschäftigungszeit zu danken. Ihre Beiträge haben zur Weiterentwicklung unserer Behörde beigetragen, und wir bedauern es aufrichtig, Sie gehen zu sehen.")
                        embed.add_field(name="",inline=False, value="Für den Rest Ihrer Beschäftigungszeit stehen wir Ihnen für einen reibungslosen Übergang zur Verfügung.\nSollten Sie weitere Fragen haben oder Unterstützung benötigen, zögern Sie bitte nicht, uns zu kontaktiere")
                        embed.add_field(name="",inline=False, value="Mit freundlichen Grüßen")
                        embed.add_field(name="",inline=False, value=f"**{verwalter}\n{position}**")
                        embed.set_footer(text=f"Rheinstadt der, {datetime.date.today().strftime('%d.%m.%Y')}")
                        await interaction.followup.send(embed=embed)
                    else:
                        embed = discord.Embed(title="Eingang der Kündigung", description=f"Sehr geehrte Frau {name},", color=discord.Color.from_rgb(255, 0, 0))
                        embed.add_field(name="",inline=False, value=f"Hiermit bestätigen wir den Erhalt Ihrer Kündigung vom **{datetime.date.today().strftime('%d.%m.%Y')}**.")
                        embed.add_field(name="",inline=False, value=f"Wir bedauern es zutiefst, dass Sie sich dazu entschieden haben, die Berufsfeuerwehr zu verlassen.")
                        embed.add_field(name="",inline=False, value=f"Gemäß den vereinbarten Bedingungen endet Ihr Arbeitsverhältnis zum **{(datetime.date.today()+datetime.timedelta(days=14)).strftime('%d.%m.%Y')}**.")
                        embed.add_field(name="",inline=False, value="Bitte beachten Sie, dass bis zu diesem Datum weiterhin alle arbeitsvertraglichen Verpflichtungen und Rechte bestehen.")
                        embed.add_field(name="",inline=False, value="Wir möchten diese Gelegenheit nutzen, um Ihnen für Ihre Mitarbeit und Ihren Einsatz während Ihrer Beschäftigungszeit zu danken. Ihre Beiträge haben zur Weiterentwicklung unserer Behörde beigetragen, und wir bedauern es aufrichtig, Sie gehen zu sehen.")
                        embed.add_field(name="",inline=False, value="Für den Rest Ihrer Beschäftigungszeit stehen wir Ihnen für einen reibungslosen Übergang zur Verfügung.\nSollten Sie weitere Fragen haben oder Unterstützung benötigen, zögern Sie bitte nicht, uns zu kontaktiere")
                        embed.add_field(name="",inline=False, value="Mit freundlichen Grüßen")
                        embed.add_field(name="",inline=False, value=f"**{verwalter}\n{position}**")
                        embed.set_footer(text=f"Rheinstadt der, {datetime.date.today().strftime('%d.%m.%Y')}")
                        await interaction.followup.send(embed=embed)
        except Exception as e:
            print(e)


    @app_commands.command(name="abmahnung", description="Abmahnung eines Mitarbeiters")
    @app_commands.choices(
        law=[
            app_commands.Choice(name="nein", value=0),
            app_commands.Choice(name="ja", value=1),
        ]
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
    @app_commands.autocomplete(genehmigt=raenge_autocomplete)
    async def abmahnung(self, interaction: discord.Interaction, user: discord.User, grund: str, verwalter: str, position: str, law: int, genehmigt: str):
        try:
            for i in interaction.user.roles:
                if i.id == 1440287614484746362 or i.id == 1440291817332674601 or interaction.user.id == 722885944969134211:
                    await interaction.response.defer(ephemeral=True)
                    if law == 0:
                        lul = "nein"
                    else:
                        lul = "ja"
                    base_url = "https://krd.nuscheltech.de/intranet/create/abmahnungohne"
                    params = {
                        "user_id": user.id,
                        "grund": grund,
                        "verwalter": verwalter,
                        "position": position,
                        "law": law,
                        
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
                    file = discord.File(BytesIO(pdf_response.content), filename="abmahnung.pdf")
                    useanalr = await self.bot.fetch_user(int(genehmigt))
                    embed = discord.Embed(title="Abmahnung wurde erstellt", description="", color=discord.Color.from_rgb(255, 0, 0))
                    embed.add_field(name="Name:", inline=True, value=f"{data.get('name')}")
                    embed.add_field(name="Grund:", inline=True, value=f"{grund}")
                    embed.add_field(name="Rechtliche Schritte:", inline=True, value=f"{lul}")
                    embed.add_field(name="Ersteller:", inline=False, value=f"{verwalter}")
                    await useanalr.send(embed=embed, file=file, view=abmahnungbutton(user.id, self.bot, grund, verwalter, position, law))


                    channel = self.bot.get_channel(1447619250045976676)

                    embed = discord.Embed(title='Eine Abmahnung wurde ausgestellt!', description='',color=color_from_interaction(interaction.id))
                    embed.add_field(name='Verwalter:', value=interaction.user.mention, inline=False)
                    embed.add_field(name='User:', value=user.mention)
                    embed.set_footer(text='Made by @eri_side')
                    await channel.send(embed=embed)
                    await interaction.followup.send("Abmahnung wurde zur Genehmigung abgeschickt!", ephemeral=True)
        except Exception as e:
            print(e)
                            
    @app_commands.command(name="sperre", description="Bewerbungssperre eines Mitarbeiters")
    @app_commands.describe(dauer="Dauer der Sperre in Monaten", grund="Grund der Sperre", ersteller="Verwalter Name", mitarbeiter="Name des Mitarbeiters")
    async def sperre(self, interaction: discord.Interaction, user: discord.User, mitarbeiter: str, dauer: int, grund:str, ersteller: str):
        try:
            for i in interaction.user.roles:
                if i.id == 1440287614484746362 or i.id == 1440291817332674601 or interaction.user.id == 722885944969134211:
                    await interaction.response.defer(ephemeral=True)

                    channel = self.bot.get_channel(1402694386298519714)
                    
                    embed = discord.Embed(title="Bewerbungssperre", description="", color=discord.Color.from_rgb(255, 0, 0))
                    embed.add_field(name="Name:", inline=True, value=f"{mitarbeiter}")
                    embed.add_field(name="Dauer:", inline=True, value=f"{(datetime.date.today() + datetime.timedelta(days=dauer*30)).strftime('%d.%m.%Y')}")
                    embed.add_field(name="Grund:", inline=True, value=f"{grund}")
                    embed.add_field(name="Ersteller:", inline=True, value=f"{ersteller}")
                    if not os.path.exists(f'sperre.json'):
                        with open(f'sperre.json', 'w') as f:
                            json.dump({}, f)
                    with open(f'sperre.json', 'r') as f:
                        data = json.load(f)
                    


                    if str(user.id) not in data:
                        data[str(user.id)] = {}

                    data[str(user.id)][str(len(data[str(user.id)]) + 1)] = {
                        "mitarbeiter": mitarbeiter,
                        "grund": grund,
                        "dauer": dauer,
                        "ersteller": ersteller,
                        "bis": (datetime.date.today() + datetime.timedelta(days=dauer*30)).strftime('%d.%m.%Y')
                    }

                    with open('sperre.json', 'w') as f:
                        json.dump(data, f, indent=4)
                    
                    
                    await channel.send(embed=embed)
                    await interaction.followup.send('Sperre wurde erstellt!', ephemeral=True)
        except Exception as e:
            print(e)


    @app_commands.command(name="zeigesperren", description="Bewerbungssperre eines Mitarbeiters ansehen")
    @app_commands.describe(user="User ID")
    async def sperreshow(self, interaction: discord.Interaction, user: str):
        try:
            if any(role.id == 1139875735436263465 for role in interaction.user.roles) or interaction.user.id == 722885944969134211:
                await interaction.response.defer(ephemeral=True)

                with open('sperre.json', 'r') as f:
                    data = json.load(f)

                if user not in data:
                    await interaction.followup.send("Keine Sperren gefunden.", ephemeral=True)
                    return

                for sperren_id, eintrag in data[user].items():
                    embed = discord.Embed(title="Bewerbungssperre", color=discord.Color.red())
                    embed.add_field(name="Name", value=eintrag.get('mitarbeiter', 'Unbekannt'), inline=True)
                    embed.add_field(name="Dauer", value=f"{eintrag.get('dauer', '?')} Monate", inline=True)
                    embed.add_field(name="Grund", value=eintrag.get('grund', 'Kein Grund angegeben'), inline=True)
                    embed.add_field(name="Ersteller", value=eintrag.get('ersteller', 'Unbekannt'), inline=True)
                    await interaction.followup.send(embed=embed, ephemeral=True)

        except Exception as e:
            print(e)
            await interaction.followup.send("Ein Fehler ist aufgetreten.", ephemeral=True)




        except Exception as e:
            print(e)

async def setup(bot):
    await bot.add_cog(kundigungen(bot))
