import asyncio
import os
import discord
from discord import Intents
from discord.ext import commands, tasks
from discord import app_commands
import yaml
import sys
import datetime
import requests

if sys.platform.startswith('win'):
    asyncio.set_event_loop_policy(asyncio.WindowsSelectorEventLoopPolicy())


intents = discord.Intents.all()
intents.members = True
intents.message_content = True
bot = commands.Bot(command_prefix="!", intents=intents, help_command=None)

def has_required_role(user: discord.Member) -> bool:
    with open("data.yaml", "r", encoding="utf-8") as file:
        data = yaml.safe_load(file)
    return any(role.id in data.get("admin_roles") for role in user.roles)



@bot.tree.command(name='load', description='Lädt einen Cog!')
async def load(interaction: discord.Interaction, name: str):
    if not has_required_role(interaction.user):
        await interaction.response.send_message("Du hast keine Berechtigung, diesen Befehl zu verwenden!", ephemeral=True)
        return
    try:
        await bot.load_extension(f"cogs.{name}")
        await interaction.response.send_message(f"Cog {name} geladen!", ephemeral=True)
    except:
        await interaction.response.send_message(f"Cog {name} nicht geladen!", ephemeral=True)

@bot.tree.command(name='unload', description='Stoppt einen Cog!')
async def unload(interaction: discord.Interaction, name: str):
    if not has_required_role(interaction.user):
        await interaction.response.send_message("Du hast keine Berechtigung, diesen Befehl zu verwenden!",
                                                ephemeral=True)
        return
    try:
        await bot.unload_extension(f"cogs.{name}")
        await interaction.response.send_message(f"Cog {name} gestoppt!", ephemeral=True)
    except:
        await interaction.response.send_message(f"Cog {name} nicht neugeladen!", ephemeral=True)

@bot.tree.command(name='reload', description='Lädt ein Cog neu!')
async def reload(interaction: discord.Interaction, name: str):
    if not has_required_role(interaction.user):
        await interaction.response.send_message("Du hast keine Berechtigung, diesen Befehl zu verwenden!",
                                                ephemeral=True)
        return
    try:
        await bot.unload_extension(f"cogs.{name}")
        await bot.load_extension(f"cogs.{name}")
        await interaction.response.send_message(f"Cog {name} neu geladen!", ephemeral=True)
    except:
        await interaction.response.send_message(f"Cog {name} nicht neugeladen!", ephemeral=True)

@bot.tree.command(name='reload_commands', description='lädt commands neu')
async def reload_commands(interaction: discord.Interaction):
    if not has_required_role(interaction.user):
        await interaction.response.send_message("Du hast keine Berechtigung, diesen Befehl zu verwenden!",
                                                ephemeral=True)
        return
    synced = await bot.tree.sync()
    await interaction.response.send_message(f'{len(synced)} Commands Synchronisiert!', ephemeral=True)

@bot.tree.command(name="upload_data", description="Lädt eine neue data.yaml hoch und ersetzt die bestehende Datei.")
async def upload_data(interaction: discord.Interaction, file: discord.Attachment):
    # Überprüfen, ob der Benutzer die erforderliche Rolle hat
    if not has_required_role(interaction.user):
        await interaction.response.send_message("Du hast keine Berechtigung, diesen Befehl zu verwenden!", ephemeral=True)
        return

    # Überprüfen, ob die Datei eine YAML-Datei ist
    if not file.filename.endswith('.yaml'):
        await interaction.response.send_message("Bitte lade eine gültige YAML-Datei hoch!", ephemeral=True)
        return

    # Pfad zur Datei
    file_path = "data.yaml"

    # Datei speichern
    try:
        with open(file_path, "wb") as f:
            f.write(await file.read())
    except Exception as e:
        await interaction.response.send_message(f"Fehler beim Speichern der Datei: {e}", ephemeral=True)
        return

    try:
        with open(file_path, "r", encoding="utf-8") as f:
            data = yaml.safe_load(f)

        if data is None:
            raise ValueError("Die YAML-Datei ist leer oder ungültig.")

        await bot.unload_extension("cogs.ticket")
        await bot.load_extension("cogs.ticket")

        await interaction.response.send_message("Die Datei wurde erfolgreich hochgeladen und ersetzt!", ephemeral=True)

    except yaml.YAMLError as e:
        await interaction.response.send_message(f"Fehler beim Laden der YAML-Datei: {e}", ephemeral=True)
        os.remove(file_path)
    except ValueError as e:
        await interaction.response.send_message(f"Fehler: {e}", ephemeral=True)
        os.remove(file_path)
    except Exception as e:
        await interaction.response.send_message(f"Unbekannter Fehler: {e}", ephemeral=True)
        os.remove(file_path)

KEY = os.getenv("DISCORD_DOWNLOAD_DATA_KEY", "")
async def check_key(interaction, key: str):
    if key == KEY:
        return True
    return False

@bot.tree.command(name="download_data", description="Lädt die aktuelle data.yaml herunter, wenn der richtige Key eingegeben wird.")
@app_commands.describe(key="Gib den Zugangsschlüssel ein")
async def download_data(interaction: discord.Interaction, key: str):
    if await check_key(interaction, key):
        file_path = "data.yaml"

        if os.path.exists(file_path):
            await interaction.response.send_message(
                content="Hier ist die Datei `data.yaml`.",
                file=discord.File(file_path)
            )
        else:
            await interaction.response.send_message("Die Datei `data.yaml` wurde nicht gefunden.", ephemeral=True)
    else:
        await interaction.response.send_message("Falscher Schlüssel! Der Download wurde abgebrochen.", ephemeral=True)



async def load_cogs():
    initial_extensions = ["cogs.arbeitsvertrag", "cogs.landesschule"]
    #initial_extensions = []
    for extension in initial_extensions:
        try:
            await bot.load_extension(extension)
        except Exception as e:
            print(e)

async def zeitgeplante_funktion():
    base_url = "https://krd.nuscheltech.de/stempeluh/wegmitalle"

    api_url = f"{base_url}"
    headers = {
        "X-API-Key": os.getenv("INTRANET_API_KEY", "")
    }
    response = requests.get(api_url, headers=headers)
    requests.get(api_url, headers=headers)


async def zeituhr():
    while True:
        now = datetime.datetime.now().strftime("%H:%M")
        if now in ["03:00", "09:00", "16:00"]:
            await zeitgeplante_funktion()
            await asyncio.sleep(60)  
        await asyncio.sleep(10)



@bot.event
async def on_ready():
    print(f'{bot.user} erfolgreich geladen')
    try:
        await load_cogs()
    except Exception as e:
        print(e)
    try:
        synced = await bot.tree.sync()
        print(f"Synced {len(synced)} command(s).")
    except Exception as e:
        print(f"Fehler beim Synchronisieren: {e}")

    await bot.change_presence(activity=discord.Game(name="lul"))



async def main():
    async with bot:
        print('Bot wurde gestartet')
        await bot.start(os.getenv("DISCORD_BOT_TOKEN", ""))



asyncio.run(main())