# 🎓 EduMentor AI

**EduMentor AI** is an AI-powered academic platform designed to help students manage their courses, study materials, and learning progress. It leverages **Google Gemma 4** (via AI API) to generate intelligent course summaries, AI-powered practice quizzes, and provide a persistent general-purpose AI chat assistant — all within a clean, modern Laravel + Livewire dashboard.

---

## ✨ Features

| Feature | Description |
|---|---|
| 🔐 **Authentication** | Email/password login, registration, email verification, and Google OAuth (Socialite) |
| 📚 **Course Management** | Create and manage academic courses with course codes, units, and semester tracking |
| 📄 **Course Materials** | Upload PDF lecture materials; text is automatically extracted and chunked |
| 🤖 **AI Summaries** | Generate AI-powered Markdown summaries from uploaded PDFs using Gemma 4 |
| 📥 **PDF Export** | Download AI summaries as formatted PDF documents |
| 🧪 **Practice Quizzes** | Auto-generate multiple-choice quizzes from course content via background jobs |
| 📊 **Academic Progress** | Track quiz scores, session history, and performance analytics |
| 💬 **AI Chat Assistant** | Persistent, general-purpose conversational AI assistant with session history |
| 🗓️ **Study Routines** | Schedule and manage study plans with reminder notifications |
| 👤 **User Profiles** | Manage profile information and linked lecturer details |

---

## 🛠️ Tech Stack

- **Backend**: PHP 8.3, Laravel 13
- **Frontend**: Livewire 3, Alpine.js, Tailwind CSS, Vite
- **AI**: Google Gemma 4 via GEMMA AI API
- **Database**: MySQL
- **Queue**: Laravel database-backed queue (for AI background jobs)
- **PDF Parsing**: `smalot/pdfparser`
- **PDF Generation**: `barryvdh/laravel-dompdf`
- **OAuth**: Laravel Socialite (Google)
---

## ⚙️ Requirements

Before cloning, make sure you have the following installed:

- **PHP** >= 8.3 (with extensions: `mbstring`, `xml`, `pdo`, `pdo_mysql`, `zip`, `gd`)
- **Composer** >= 2.x
- **Node.js** >= 18.x & **npm**
- **MySQL** >= 8.0
- A **Gemma AI API key** (for AI features)
- A **Google OAuth App** (for Google login — optional)
- A **Gmail SMTP App Password** (for email notifications — optional)

---

## 🚀 Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/adamuibrahim858/EduMentorAI.git
cd EduMentorAI
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node.js Dependencies

```bash
npm install
```

### 4. Configure Environment Variables

Copy the example environment file and edit it:

```bash
cp .env.example .env
```

Open `.env` and update the following values:

```env
APP_NAME="EduMentor AI"
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=edumentorai
DB_USERNAME=root
DB_PASSWORD=your_mysql_password

# Queue & Sessions (uses database driver)
QUEUE_CONNECTION=database
SESSION_DRIVER=database

# AI Service (required for AI features)
GEMMA_AI_API_KEY=your_gemma_api_key_here

# Google OAuth (optional — for "Login with Google")
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"

# Email (optional — for email notifications & verification)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_gmail_app_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="your_email@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Create the Database

Create a MySQL database named `edumentorai` (or whatever you set in `.env`):

```sql
CREATE DATABASE edumentorai CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Run Database Migrations

```bash
php artisan migrate
```

### 8. Create Storage Link

```bash
php artisan storage:link
```

---

## 🏃 Running the Application

EduMentor AI requires **four concurrent processes** to run properly:

| Process | Purpose |
|---|---|
| `php artisan serve` | Laravel web server |
| `php artisan queue:listen` | Background AI job worker |
| `npm run dev` | Vite frontend asset compiler |
| `php artisan pail` | Log viewer (optional) |

### Option A — Run Everything at Once (Recommended)

Use the built-in Composer dev script which launches all processes concurrently:

```bash
composer run dev
```

> This requires `npx` and `concurrently` to be available. The script uses `concurrently` (installed via npm) to run all four processes simultaneously with color-coded output.

### Option B — Run Processes Individually

Open four separate terminal tabs/windows:

**Terminal 1 — Web Server:**
```bash
php artisan serve
```

**Terminal 2 — Queue Worker (required for AI jobs):**
```bash
php artisan queue:listen --tries=1 --timeout=0
```

**Terminal 3 — Vite Assets:**
```bash
npm run dev
```

**Terminal 4 — Log Viewer (optional):**
```bash
php artisan pail
```

Then open your browser and navigate to: **http://localhost:8000**

---

## 🗄️ Database Overview

The application uses the following key tables:

```
users                     — Registered user accounts
user_profiles             — Extended profile information
courses                   — Student courses (code, title, unit, semester)
lecturers                 — Lecturer info linked to courses
course_materials          — Uploaded PDF files per course
document_chunks           — Extracted text chunks from PDFs (for AI)
summaries                 — AI-generated summaries per material
practice_sets             — Practice quiz sets per material
questions / options       — Quiz questions and answer choices
user_practice_sessions    — Recorded quiz attempt sessions
user_answers              — Per-question answers from quiz sessions
chat_sessions             — AI chat conversation sessions
chat_messages             — Individual messages in chat sessions
study_routines            — Scheduled study plans
```

---

## 🤖 How It Works

### AI Summary Generation
1. A student uploads a PDF file to a course.
2. A background job (`ExtractPdfTextJob`) parses the PDF using `smalot/pdfparser` and splits the text into chunks stored in `document_chunks`.
3. The student clicks **"Generate AI Summary"**.
4. `GenerateSummaryJob` sends the extracted content to the **Gemma 4 AI API**, which returns a structured Markdown summary.
5. The summary is saved to the `summaries` table and a formatted PDF is generated via `GenerateSummaryPdfJob`.

### AI Practice Quiz Generation
1. After a summary is generated, the student can request an **AI Practice Quiz**.
2. `GeneratePracticeJob` sends the material content to Gemma 4 to generate multiple-choice questions.
3. The job parses both JSON and Markdown bullet-point AI responses with a multi-format parser and a fallback model strategy.
4. Questions and options are saved in `questions` and `options` tables, linked to a `practice_set`.
5. The student takes the quiz interactively, and results are saved to `user_practice_sessions`.

### AI Chat Assistant
1. The floating chat widget is available on every authenticated page.
2. Each user has a persistent `ChatSession`; messages are stored in `chat_messages`.
3. When a message is sent, the full conversation history is passed to the Gemma 4 API along with a system prompt defining the assistant's persona.
4. Responses are streamed back and displayed with Markdown rendering (code blocks, tables, bullet points, etc.).
5. Users can start a new chat session at any time; all previous sessions are preserved in the database.

### Google OAuth Flow
1. User clicks **"Continue with Google"**.
2. Laravel Socialite redirects to Google's OAuth consent screen.
3. On callback, the user account is created or matched by email.
4. The user is authenticated and redirected to the dashboard.

---

## 📁 Key Project Structure

```
app/
├── Http/Controllers/       # Standard HTTP controllers (PDF download, OAuth, etc.)
├── Jobs/                   # Background queue jobs
│   ├── ExtractPdfTextJob.php
│   ├── GenerateSummaryJob.php
│   ├── GenerateSummaryPdfJob.php
│   └── GeneratePracticeJob.php
├── Livewire/               # Reactive Livewire components
│   ├── Auth/               # Login, Register, Forgot/Reset Password
│   ├── Chat/               # AI Chat Assistant
│   ├── Course/             # Course management & material uploads
│   ├── Dashboard/          # Dashboard overview
│   ├── Practice/           # Quiz interface
│   ├── Progress/           # Academic progress tracking
│   └── Routine/            # Study routine management
├── Models/                 # Eloquent models
├── Notifications/          # Laravel notification classes
└── Services/
    ├── GemmaAIService.php  # Gemma 4 AI API integration
    └── NotificationService.php

resources/views/
├── layouts/                # Dashboard & auth layout templates
├── livewire/               # Livewire component blade views
└── pdf/                    # PDF export templates (DomPDF)
```

---

## 🔑 Getting a Gemma AI API Key

1. Visit the [Google AI Studio](https://aistudio.google.com/) or the Gemma API provider dashboard.
2. Create or log into your account.
3. Generate an API key.
4. Add it to your `.env` file as `GEMMA_AI_API_KEY=your_key_here`.

> **Note:** The free tier has daily quota limits. If you exceed the quota, the AI features will display a friendly message and retry on the next request.

---

## 🏆 Hackathon — Demo Credentials

> **For hackathon judges only.** A working `.env` file with all required credentials has been submitted alongside this repository. Copy it to the project root before running the application.

### Steps for Judges

1. Use the `.env` file provided with the submission (do **not** create a new one from `.env.example`).
2. Run `php artisan migrate` to set up the database.
3. Start the app with `composer run dev`.
4. Open **http://localhost:8000** — all AI features (Gemma 4) and Google OAuth are pre-configured and ready.

> **Note:** The Gemma AI free tier has daily quota limits. If AI features display a quota message, the limit has been reached for the day — please try again the following day.

---

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/your-feature-name`
3. Commit your changes: `git commit -m "feat: add your feature"`
4. Push to the branch: `git push origin feature/your-feature-name`
5. Open a Pull Request

---

## 📜 License

This project is open-source and available under the [MIT License](LICENSE).

---

## 👨‍💻 Author

Built with ❤️ by **Adamu Ibrahim** — powered by Laravel, Livewire, and Google Gemma 4 AI.
