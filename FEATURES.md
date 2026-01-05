# LitePay Features 🚀

LitePay is a comprehensive payment gateway and digital services platform featuring a mobile-first customer experience, a robust merchant dashboard, and an advanced admin panel.

## 📱 Customer Storefront (Mobile-Optimized)

The customer-facing application is designed with a "Mobile-First" approach, simulating a native app experience on the web.

*   **App-Like Interface**:
    *   Wrapped in a mobile-width container (`max-w-md`) for consistent UX across devices.
    *   **5-Item Bottom Navigation**: Home, History, Scan (Central Floating Action), Inbox, Profile.
    *   Modern styling with Tailwind CSS and custom fonts (Inter/Outfit).

*   **Shopping & Transactions**:
    *   **Homepage**: Quick access to top categories (Pulsa, Data, PLN, Games).
    *   **Category Flows**: Optimized purchase flows for digital goods (e.g., "Buy Data" with phone number validation).
    *   **Distraction-Free Checkout**: Dedicated checkout page with hidden navigation to increase conversion focus.
    *   **Payment Methods**: Support for Bank Transfers (BCA, Mandiri, BRI, BNI) and QRIS/E-Wallets (GoPay, OVO, Dana, ShopeePay).
    *   **Success Page**: Clear payment receipts with "Return to Merchant" actions.

*   **User Management**:
    *   **Authentication**: secure Login/Register for customers.
    *   **History**: Track recent transactions and statuses.
    *   **Profile**: Manage account details and settings.

## 🏢 Merchant Dashboard

Tools for merchants to manage their business and payments.

*   **Dashboard**: Real-time overview of sales and incoming payments.
*   **Transaction Management**: View and filter transaction history.
*   **Invoicing**: Create and manage invoices for customers.
*   **Integration**: API credentials and documentation.

## ⚡ Admin Pro Dashboard

A powerful, high-fidelity dashboard for platform administration.

*   **Core Management**:
    *   **Dashboard**: Comprehensive analytics and charts.
    *   **Merchants**: Onboard and manage merchant accounts (featuring "Add Merchant" modals).
    *   **Transactions**: Global transaction monitoring.

*   **Financials**:
    *   **Balance**: Track platform revenue, top-ups, and withdrawals.
    *   **Settlements**: Manage payouts to merchants.

*   **Technical & Security**:
    *   **API Management**: Manage API keys and permissions.
    *   **Callbacks**: Monitor payment gateway webhook logs.
    *   **Risk Management**: Fraud detection and risk scoring.
    *   **IP Whitelist**: Security controls for admin access.

*   **AI Assistance**:
    *   **Chatbot**: Integrated Gemini AI assistant for administrative tasks and data querying.

## 🛠 Backend & Infrastructure

*   **Framework**: Built on Laravel 10/11.
*   **Authentication**: Multi-guard system separating Customers, Merchants, and Admins.
*   **API**: RESTful API endpoints for payment processing (`/payment/pay`, `/callback`).
*   **Database**: MySQL with optimized schema for transactions and logs.
