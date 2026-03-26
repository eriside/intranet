import discord
from discord.ext import commands
from discord import app_commands
import datetime
import json
import os

class pingwarn(commands.Cog):
    def __init__(self, bot):
        super().__init__()
        self.bot = bot

    @app_commands.command(name="wping", description="Warnt einen Mitarbeiter für unnötiges Pingen")   
    async def wping(self, interaction: discord.Interaction, member: discord.Member):
        try:
            # Rollen- oder Benutzerberechtigung prüfen
            is_allowed = (
                interaction.user.id == 722885944969134211 or 
                any(role.id == 1139875735436263465 for role in interaction.user.roles)
            )

            if not is_allowed:
                await interaction.response.send_message("Keine Berechtigung.", ephemeral=True)
                return

            filename = f'pingwarns{interaction.guild.id}.json'

            if not os.path.exists(filename):
                with open(filename, 'w') as f:
                    json.dump({}, f)

            with open(filename, 'r') as f:
                data = json.load(f)

            if str(member.id) in data:
                data[str(member.id)]['warns'] += 1
            else:
                data[str(member.id)] = {'warns': 1}

            warns = data[str(member.id)]['warns']

            if warns == 3:
                await member.timeout(datetime.timedelta(hours=24), reason="Unnötiges Pingen")
                data[str(member.id)]['warns'] = 0

                embed = discord.Embed(
                    title="Unnötiges Pingen",
                    color=discord.Color.from_rgb(255, 0, 0)
                )
                embed.add_field(name="", value="Sie wurden für 24h getimeoutet.", inline=False)
                embed.set_footer(text=f"Rheinstadt der, {datetime.date.today().strftime('%d.%m.%Y')}")
                await member.send(embed=embed)
                await interaction.response.send_message('User wurde getimeoutet.', ephemeral=True)
            else:
                embed = discord.Embed(
                    title="Unnötiges Pingen",
                    color=discord.Color.from_rgb(255, 0, 0)
                )
                embed.add_field(name="", value="Hiermit möchten wir Sie darauf hinweisen, dass Sie für unnötiges Pingen gewarnt wurden.", inline=False)
                embed.add_field(name="", value=f"Warns: {warns}/3", inline=False)
                embed.add_field(name="", value="Beim dritten Warn erhalten Sie einen 24h Timeout.", inline=False)
                embed.set_footer(text=f"Rheinstadt der, {datetime.date.today().strftime('%d.%m.%Y')}")
                await member.send(embed=embed)
                await interaction.response.send_message('User wurde gewarnt.', ephemeral=True)

            with open(filename, 'w') as f:
                json.dump(data, f, indent=4)

        except Exception as e:
            print(e)


async def setup(bot):
    await bot.add_cog(pingwarn(bot))
