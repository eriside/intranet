import discord
from discord.ext import commands


class Register(discord.ui.View):
    def __init__(self,bot):
        super().__init__(timeout=None)
        self.bot = bot

    @discord.ui.button(label='Registrieren', style=discord.ButtonStyle.primary, custom_id='1')
    async def button_callback(self, interaction: discord.Interaction, button: discord.ui.Button):
        guild = self.bot.get_guild(1058946637113864232)
        user = guild.get_member(interaction.user.id)
        rol = []
        try:
            for i in interaction.user.roles:
                try:
                    if i.name == '@everyone':
                        pass
                    elif i.id == 1329475801539805287:
                        pass
                    elif i.id == 1329475812231221312:
                        pass
                    elif i.id == 1329475816962396160:
                        pass
                    elif i.id == 1329475819244097548:
                        pass
                    elif i.id == 1329475826659364957:
                        pass
                    elif i.id == 1329475827938623528:
                        pass
                    elif i.id == 1329475829608218685:
                        pass
                    elif i.id == 1329475831382278234:
                        pass
                    elif i.id == 1329475834485932032:
                        pass
                    elif i.id == 1329475828366708787:
                        pass
                    elif i.id == 1329475810045984850:
                        pass
                    else:
                        await interaction.user.remove_roles(i)
                except:
                    await interaction.response.send_message(f"Etwas ist schiefgelaufen, bitte melde dich bei einem Administrator!", ephemeral=True)
                    break

            for role in user.roles:
                if role.id == 1058947974388011048:
                    rol.append(interaction.guild.get_role(1058947974388011048 ).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475814131241042))
                elif role.id == 1058949072242868284 :
                    rol.append(interaction.guild.get_role(1329475814856589374).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475814856589374))
                elif role.id == 1066330212540874782:
                    rol.append(interaction.guild.get_role(1329475815360167936).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475815360167936))
                elif role.id == 1070076368064348240:
                    rol.append(interaction.guild.get_role(1329475815817084968).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475815817084968))
                elif role.id == 1113881546181578913:
                    rol.append(interaction.guild.get_role(1329475816412680345).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475816412680345))
                elif role.id == 1107362187955151018:
                    rol.append(interaction.guild.get_role(1329640142599884861).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329640142599884861))
                elif role.id == 1266440092587790336:
                    rol.append(interaction.guild.get_role(1329640145531441172).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329640145531441172))
                elif role.id == 1247248345852805222:
                    rol.append(interaction.guild.get_role(1329640123708739686).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329640123708739686))
                elif role.id == 1338522899404816406:
                    rol.append(interaction.guild.get_role(1338523518068981790).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1338523518068981790))
                elif role.id == 1113881775085735956:
                    rol.append(interaction.guild.get_role(1329475819718049822).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475819718049822))
                elif role.id == 1225114643547029615:
                    rol.append(interaction.guild.get_role(1329475820372361357).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475820372361357))
                elif role.id == 1161675694682677298:
                    rol.append(interaction.guild.get_role(1329475821886509056).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475821886509056))
                elif role.id == 1122919658635403336:
                    rol.append(interaction.guild.get_role(1329475822536491129).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475822536491129))
                elif role.id == 1140005776157593630:
                    rol.append(interaction.guild.get_role(1329475823605911552).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475823605911552))
                elif role.id == 1161676489775923240:
                    rol.append(interaction.guild.get_role(1329475823836856320).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475823836856320))
                elif role.id == 1270791381895348294:
                    rol.append(interaction.guild.get_role(1329475824222732288).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475824222732288))
                elif role.id == 1247560255563366400:
                    rol.append(interaction.guild.get_role(1329475824839032915).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475824839032915))
                elif role.id == 1186355594576273599:
                    rol.append(interaction.guild.get_role(1329475825569108050).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475825569108050))
                elif role.id == 1321997925953310760:
                    rol.append(interaction.guild.get_role(1329475813640503368).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475813640503368))
                elif role.id == 1321997917778743367:
                    rol.append(interaction.guild.get_role(1329475813640503368).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475813640503368))
                elif role.id == 1316121520099037284:
                    rol.append(interaction.guild.get_role(1329475817528496198).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475817528496198))
                elif role.id == 1113881901317488742:
                    rol.append(interaction.guild.get_role(1330230373627592775).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1330230373627592775))
                elif role.id == 1246922996275351583:
                    rol.append(interaction.guild.get_role(1329475826856755304).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475826856755304))
                elif role.id == 1190008835457417246:
                    rol.append(interaction.guild.get_role(1329475817784475701).name)
                    await interaction.user.add_roles(interaction.guild.get_role(1329475817784475701))


            try:
                await interaction.user.edit(nick=user.nick)
                channel = interaction.guild.get_channel(1338317071192293406)
                await interaction.response.send_message(f"Du wirst Registriert!", ephemeral=True)
                await channel.send(f'<@{interaction.user.id}> hat folgende Rollen erhalten: {rol}')

            except:
                await interaction.response.send_message(f"Etwas ist schiefgelaufen, bitte melde dich bei einem Administrator!", ephemeral=True)


        except:
            await interaction.response.send_message(f"Etwas ist schiefgelaufen, bitte melde dich bei einem Administrator!", ephemeral=True)




class regestrierung(commands.Cog):
    def __init__(self, bot):
        self.bot = bot


    @commands.Cog.listener()
    async def on_member_join(self, member):
        
        guild = member.guild
        if guild.id == 1329471191320100985:
            channel = self.bot.get_channel(1329495596658200657)
            if channel:

                embed = discord.Embed(
                    title='',
                    description="# **Willkommen**",
                    color=0xff2d00
                )
                embed.add_field(name='', value=f'👋 Willkommen bei uns in der Leitung!{member.mention}', inline=False)
                embed.set_thumbnail(url='https://krd.nuscheltech.de/images/lulbf.png')
                embed.set_author(name='Berufsfeuerwehr Rheinstadt', icon_url='https://krd.nuscheltech.de/images/lulbf.png')
                embed.add_field(name='', value='', inline=False)
                embed.add_field(name='', value="Wir freuen uns, dich an Bord zu haben. 🚔\nMach dich bereit für spannende Einsätze und eine großartige Zeit! 🎉", inline=False)
                embed.add_field(name='', value="\nViel Spaß! 🚓✨", inline=False)
                embed.set_footer(text="Made with ❤️ by @eri_side")
                await channel.send(embed=embed)

        elif guild.id == 1259251655434829865:
            await member.add_roles(guild.get_role(1259482742509277254))
            channel = self.bot.get_channel(1259257495789244519)
            if channel:

                embed = discord.Embed(
                    title='',
                    description="# **Willkommen**",
                    color=0xff2d00
                )
                embed.add_field(name='', value=f'👋 Willkommen bei uns in der Berufsfeuerwehr Rheinstadt{member.mention}!', inline=False)
                embed.set_thumbnail(url='https://krd.nuscheltech.de/images/lulbf.png')
                embed.set_author(name='Berufsfeuerwehr Rheinstadt', icon_url='https://krd.nuscheltech.de/images/lulbf.png')
                embed.add_field(name='', value='', inline=False)
                embed.add_field(name='', value="Wir freuen uns, dich an Bord zu haben. 🚔\nMach dich bereit für spannende Einsätze und eine großartige Zeit! 🎉", inline=False)
                embed.add_field(name='', value="\nViel Spaß! 🚓✨", inline=False)
                embed.set_footer(text="Made with ❤️ by @eri_side")
                await channel.send(embed=embed)
        elif guild.id == 1280996486095831100:
            channel = self.bot.get_channel(1395014480810868796)
            if channel:
                embed = discord.Embed(
                    title='',
                    description="# **Willkommen**",
                    color=0xff2d00
                )
                embed.add_field(name='', value=f'👋 Willkommen bei uns in der Zentrale Ausbildungsstätte für Feuerwehr und Rettungsdienst Rheinstadt {member.mention}!', inline=False)
                embed.set_thumbnail(url='https://krd.nuscheltech.de/images/landesschulelogo.png')
                embed.set_author(name='Zentrale Ausbildungsstätte', icon_url='https://krd.nuscheltech.de/images/landesschulelogo.png')
                embed.add_field(name='', value='', inline=False)
                embed.add_field(name='', value="Wir freuen uns, dich an Bord zu haben. 🚔\nMach dich bereit für spannende Einsätze und eine großartige Zeit! 🎉", inline=False)
                embed.add_field(name='', value="\nViel Spaß! 🚓✨", inline=False)
                embed.set_footer(text="Made with ❤️ by @eri_side")
                await channel.send(embed=embed)
            
            

    @commands.Cog.listener()
    async def on_member_remove(self, member):
        guild = member.guild
        if guild.id == 1259251655434829865:
            channel = self.bot.get_channel(1259257473655636018)
            if channel:
                embed = discord.Embed(
                    title='👋 Mitglied hat den Server verlassen',
                    description=f"{member.mention} hat den Server verlassen.",
                    color=discord.Color.dark_red()
                )
                embed.set_thumbnail(url=member.avatar.url if member.avatar else guild.icon.url)
                embed.set_footer(text="Made with ❤️ by @eri_side")
                await channel.send(embed=embed)
        if guild.id == 1280996486095831100:
            channel = self.bot.get_channel(1395055123805376522)
            if channel:
                embed = discord.Embed(
                    title='👋 Mitglied hat den Server verlassen',
                    description=f"{member.mention} hat den Server verlassen.",
                    color=discord.Color.dark_red()
                )
                embed.set_thumbnail(url=member.avatar.url if member.avatar else guild.icon.url)
                embed.set_footer(text="Made with ❤️ by @eri_side")
                await channel.send(embed=embed)
        







async def setup(bot):
    channel = bot.get_channel(1338308773910937761)
    await channel.purge(limit=1)
    embed = discord.Embed(
        title="Registrierung!",
        description="📢 Willkommen auf unserem Server! 🚔",
        color=0xff2d00
    )
    embed.add_field(name='', value='Bevor du dich ins Abenteuer stürzt, gibt es noch etwas zu erledigen:', inline=False)
    embed.add_field(name='', value='', inline=False)
    embed.add_field(name='', value='Klicke dazu unten auf den Button!', inline=False)
    embed.add_field(name='', value='', inline=False)
    embed.add_field(name='', value='🎉 Sobald das erledigt ist, bist du startklar!', inline=False)
    embed.add_field(name='', value='Viel Spaß und Erfolg bei deinem Dienst. 🚓✨', inline=False)
    embed.set_author(name='Berufsfeuerwehr Rheinstadt | Leitung')
    embed.set_image(url='http://images-ext-1.discordapp.net/external/KEUsMduyw3CeXj8TPE85NMYDJ0Gdrhoth4Bb71ykRWc/http/s3.galaxybot.app/server/1329471191320100985/5fefc74f-b806-419c-8485-bf2bdc079ce1.png?format=webp&quality=lossless&width=1440&height=318')
    await channel.send(embed=embed, view=Register(bot))

    
    await bot.add_cog(regestrierung(bot))
