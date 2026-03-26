# Intranet Talstein

Intranet Talstein ist eine Laravel-11-Anwendung mit:
- Web-Frontend (Blade, Vite, Tailwind/Bootstrap)
- API-Endpunkten fuer Discord-Workflows
- PDF-Generierung (DomPDF)
- Google-Drive/Docs-Integration fuer Dokumente
- Discord-Bot (Python) fuer Vertrags-/Ausbildungsprozesse

## Tech Stack

- PHP 8.2+
- Laravel 11
- MySQL (lokal oder extern)
- Node.js + npm (Vite Assets)
- Python 3.10+ (Discord Bot)

## Projektstruktur

- `app/Http/Controllers`:
	Business-Logik und API-Endpunkte (u. a. Dokumente, Mitarbeiter, Landesschule, Stempeluhr)
- `app/Jobs`:
	Queue-Jobs (z. B. SignCertificates)
- `app/Models`:
	Eloquent-Modelle
- `resources/views`:
	Blade-Views fuer das Intranet
- `routes/web.php`:
	Web-Routen
- `routes/api.php`:
	API-Routen
- `database/migrations`:
	Schema-Migrationen
- `bot`:
	Discord-Bot inklusive Cogs

## Einrichtung (Web-App)

1. Abhaengigkeiten installieren

```bash
composer install
npm install
```

2. Umgebungsdatei erstellen

```bash
cp .env.example .env
# Windows PowerShell Alternative:
Copy-Item .env.example .env
```

3. `.env` pflegen

- Datenbankzugang eintragen
- Discord/Gateway/Webhook-Werte setzen
- Google API Werte setzen

4. App Key erzeugen

```bash
php artisan key:generate
```

5. Migrationen ausfuehren

```bash
php artisan migrate
```

6. Development starten

```bash
composer run dev
```

Der `dev`-Befehl startet parallel:
- Laravel Server
- Queue Listener
- Log Tail (`artisan pail`)
- Vite Dev Server

## Wichtige ENV-Variablen

In `.env.example` sind alle benoetigten Keys hinterlegt. Besonders wichtig:

- `INTRANET_API_KEY`:
	Shared API-Key zwischen Bot und Laravel-Endpunkten
- `DISCORD_BOT_TOKEN`:
	Discord Bot Login Token
- `DISCORD_DOWNLOAD_DATA_KEY`:
	Freigabeschluessel fuer Bot-Downloadbefehl
- `DISCORD_WEBHOOK_*`:
	Webhooks fuer verschiedene Benachrichtigungen
- `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REFRESH_TOKEN`:
	Google Drive/Docs Zugriff fuer Dokument-Workflows

## Discord-Bot (Python)

Der Bot liegt im Ordner `bot`.

Empfohlene lokale Einrichtung:

```bash
cd bot
python -m venv .venv
# Windows PowerShell
.\.venv\Scripts\Activate.ps1
pip install discord.py PyYAML requests PyPDF2 async-timeout
python main.py
```

Hinweise:
- Der Bot nutzt dieselben Kernvariablen (`INTRANET_API_KEY`, `DISCORD_BOT_TOKEN`, `DISCORD_DOWNLOAD_DATA_KEY`).
- Starte den Bot im selben Environment, in dem diese Variablen vorhanden sind.

## Queue und Hintergrundjobs

Einige Prozesse laufen ueber Queues (z. B. Zertifikatsversand). Lokal reicht in der Regel:

```bash
php artisan queue:listen --tries=1
```

In Produktion sollte ein stabiler Worker-Prozess (z. B. Supervisor) verwendet werden.

## Build/Test/Betrieb

- Assets bauen:

```bash
npm run build
```

- Tests:

```bash
php artisan test
```

- Logs:

```bash
php artisan pail --timeout=0
```

## Sicherheit

- Keine Secrets im Code speichern.
- Nur `.env` fuer sensible Daten verwenden.
- `.env` niemals committen.
- Bei Leak sofort Token/Keys rotieren (Discord, Google, Webhooks).
