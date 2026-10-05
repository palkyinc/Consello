# Consello

Ticketing and door-access control for events, built with Laravel 11 and Livewire.

Consello lets an organizer sell tickets with optional add-ons (food and drinks) in advance, track who is attending, and validate entry at the door by scanning a QR code from a phone. Add-ons are then marked as delivered at the bar, so nothing is handed out twice.

> The user interface is in Spanish, as the app was built for an event in Argentina.

<!-- TODO: add 3-4 screenshots in docs/screenshots/ and reference them here:
![Event dashboard](docs/screenshots/dashboard.png)
![Door scanner](docs/screenshots/door-scanner.png)
-->

## Features

- **Events**: create and manage events with capacity (`aforo`) and active/inactive state.
- **Add-ons**: define extras per event (drinks, food) that buyers can pre-purchase with their ticket.
- **Reservations**: buyers reserve up to a configurable number of tickets per purchase, capped by the event capacity.
- **Bank-transfer payments**: the buyer uploads a deposit receipt; an admin reviews and approves it from the dashboard.
- **Attendee assignment**: the buyer assigns each ticket to a named attendee, so the organizer knows exactly who is coming.
- **QR tickets**: every ticket has a unique code (`YYYYMMDD-00001-ABC123`) rendered as a QR and sent by email.
- **Door scanner**: staff scan the QR from a phone camera; the app checks the event, payment and assignment before allowing check-in.
- **Bar scanner**: staff scan the QR to see the add-ons purchased and mark each one as delivered.
- **Automatic cleanup**: reservations without a payment receipt are cancelled after 2 hours and the buyer is notified by email.
- **Roles and permissions**: `Admin`, `Cliente`, `Staff Admin`, `Staff Ingreso` (door) and `Staff Barra` (bar), with granular permissions per screen.
- **Transactional emails**: reservation confirmed, payment approved, ticket assigned, QR ticket, reservation cancelled, contact form.

## Ticket flow

1. The buyer registers, verifies their email and reserves tickets (with add-ons) for an event.
2. The buyer pays by bank transfer and uploads the receipt.
3. An admin approves the payment.
4. The buyer assigns each ticket to an attendee and receives the QR by email.
5. At the door, staff scan the QR and check the attendee in.
6. At the bar, staff scan the QR and mark add-ons as delivered.

## Tech stack

| Area | Technology |
| --- | --- |
| Backend | PHP 8.2+, Laravel 11 |
| UI | Livewire 3, Volt, Alpine.js, Tailwind CSS, Vite |
| Auth | Laravel Breeze, email verification, password expiration and complexity rules |
| Authorization | [spatie/laravel-permission](https://github.com/spatie/laravel-permission) |
| QR | simplesoftwareio/simple-qrcode (generation), html5-qrcode (camera scanning) |
| Email | Symfony Brevo mailer (SMTP) |
| Queue / cache / sessions | Database drivers |

### Code layout

- `app/Livewire/`: one component per screen and modal (events, add-ons, reservations, door and bar scanners, users, roles, permissions).
- `app/Models/`: `Evento`, `Adicional`, `Reserva`, `Adicional_Cache` (add-ons purchased in a reservation) and `User`.
- `app/Mail/`: mailables for each stage of the ticket flow.
- `app/Console/Commands/DeleteUnpaidReservations.php`: scheduled cleanup of unpaid reservations.
- `config/constants.php`: roles, permissions, contact emails and the per-purchase ticket limit.

## Getting started

Requirements: PHP 8.2+, Composer, Node.js 18+.

```bash
git clone https://github.com/palkyinc/Consello.git
cd Consello
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
```

Configure the database in `.env`. The default is SQLite for local development.

The permissions migration assigns the `Admin` role to the user with id 1, so that user must exist before it runs:

```bash
# 1. Create only the users table
php artisan migrate --path=database/migrations/0001_01_01_000000_create_users_table.php

# 2. Register the first user from the web app (or with tinker), then:
php artisan migrate
```

Start the app and the queue worker:

```bash
php artisan serve
php artisan queue:work
```

## Configuration

Add these to `.env` to send real emails through Brevo:

```env
MAIL_MAILER=brevo
BREVO_SMTP_LOGIN=
BREVO_SMTP_KEY=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="Consello"
```

Other settings live in `config/constants.php`:

- `RESERVAS_MAX`: maximum tickets per purchase.
- `CONTACT_EMAILS`: recipients of the contact form.

### Scheduled tasks

Unpaid reservations are removed by `php artisan reservations:delete-unpaid`, and queued emails by `php artisan queue:work --stop-when-empty`. Run both from your scheduler or cron (see the `/cron/...` route in `routes/web.php` for shared-hosting setups).

## Roadmap

- [ ] Email 72 hours before the event warning buyers about tickets without an assigned attendee.
- [ ] Email 24 hours before the event with the QR for assigned tickets.
- [ ] "Resend QR email" button.
- [ ] Automated tests for ticket validation, check-in and add-on delivery.

## Status

Version 0.0.10. See [CHANGELOG.md](CHANGELOG.md) for the history.
