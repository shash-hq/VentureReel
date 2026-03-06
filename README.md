# VentureReel 🎥 
A curated, high-performance directory for founder stories, startup pitches, and tech insights.

## Live Demo
[VentureReel - Live Deployment](#) *(Deployment pending on Railway)*

## Tech Stack
VentureReel is a modern server-rendered application built for speed, SEO, and robust data management.
* **Core Framework:** Laravel (PHP)
* **Database:** MySQL
* **Frontend templating:** Blade
* **Reactivity:** AlpineJS
* **Styling:** Tailwind CSS
* **External APIs:** YouTube Data API v3
* **Transactional Email:** Resend emails

## Key Features
* **YouTube Hybrid Search with One-Click Import:** Search for any founder or company. Our engine checks the local database first and gracefully falls back to a live YouTube API search. Import any public video directly into the platform with full metadata ingestion in a single click.
* **Founder Collections:** Curate groups of related videos (e.g., "Y Combinator 2024", "Fintech Disruptors") with an integrated follow/subscription system.
* **Personalized Recommendations:** We track authenticated user search histories and dynamically render a tailored "Based on your searches" feed.
* **Email Verification via Resend:** Secure user accounts via strict RFC email validation and automated verification emails dispatched via the Resend API.
* **Glassmorphism UI & Dark Mode:** A stunning, CSS-native frosted glass aesthetic mapped perfectly across both light and dark native OS modes natively integrated using Tailwind.
* **Admin Analytics Dashboard:** A protected administrative command center highlighting Daily Active Users (DAU), top trending videos, platform aggregates, and collection management via intuitive internal REST controllers.

## Architecture
VentureReel operates on a clean, scalable Model-View-Controller (MVC) architecture ensuring strong separation of concerns:
**Routes → Middleware → Controller → Service → Model → Blade View**

* **Routing & Middleware:** Web and Auth routes dictate access, firmly protected by rate limiters (Throttle), Content Security Policies, and Auth/Admin verification middleware.
* **Controllers:** Lean, single-responsibility PHP classes that orchestrate data gathering and parameter sanitation.
* **Services:** Heavy external logic (e.g., executing YouTube API fetches or image caching logic) is abstracted directly into dedicated service classes like `YouTubeService.php`.
* **Models:** Eloquent ORM bindings defining relationships between Users, Videos, and pivoting polymorphic Collections.
* **Views:** Server-rendered HTML utilizing Blade templating tightly coupled with scoped AlpineJS states for rapid browser interactions without heavy client-side Javascript frameworks.

## Local Setup
Get VentureReel running locally in a few minutes.

**1. Clone the repository**
```bash
git clone https://github.com/shash-hq/VentureReel.git
cd VentureReel
```

**2. Install Dependencies**
```bash
composer install
npm install
```

**3. Configure Environment**
Copy the standard environment variables template:
```bash
cp .env.example .env
```
Generate your application key:
```bash
php artisan key:generate
```
Open the `.env` file and configure your local database credentials (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`), mailer credentials (`RESEND_KEY`), and your Google Cloud project's API key (`YOUTUBE_API_KEY`).

**4. Run Migrations & Seeders**
Bootstrap the database schema and populate the platform with initial foundational data:
```bash
php artisan migrate:fresh --seed
```

**5. Start the Server**
Launch the local PHP server and Vite hot module replacement (HMR) for frontend assets. (Run these in separate terminal windows).
```bash
php artisan serve
npm run dev
```
Navigate to `http://localhost:8000` or `http://127.0.0.1:8000` to view the application.

## Screenshots
<br>

**(Application UI Screenshots — Space reserved for post-deployment production captures)**

<br>

## Author
Built by [Shashank Ranjan](https://github.com/shash-hq).
