# 🚀 WhatsApp Quick Start (60 Seconds!)

## Step 1: Add to .env (30 seconds)

Open your `.env` file and add:

```env
WHATSAPP_PHONE=962791234567
```

**Change `962791234567` to YOUR WhatsApp number!**

Format: Country code + number (no + or spaces)
- Jordan: `962791234567`
- Saudi: `966501234567`
- UAE: `971501234567`

---

## Step 2: Clear Cache (15 seconds)

```bash
php artisan config:clear && php artisan cache:clear
```

---

## Step 3: Test! (15 seconds)

1. Go to **Admin → Orders**
2. Click any order
3. Click green **"Send to WhatsApp"** button
4. WhatsApp opens with order details!

**Done!** 🎉

---

## For WhatsApp Group Instead:

Replace step 1 with:

```env
WHATSAPP_GROUP_ID=962791234567-1234567890
```

(Get group ID from WhatsApp Web URL or contact developer)

---

## That's It!

✅ 100% Free
✅ No API keys
✅ Unlimited messages
✅ Works everywhere

**Total time: 1 minute!** ⏱️

---

## Need Help?

Read: `WHATSAPP-WAME-SETUP.md` (detailed guide)
