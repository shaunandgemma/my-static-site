---

# Dynamic Website on EC2 (Using PHP)

This guide shows how to turn your EC2 website into a **dynamic** site using **PHP**.
This helps you see the clear difference between **EC2 (dynamic)** and **S3 (static)**.

---

## ⭐ What PHP Is (Simple Explanation)

* PHP is a **server-side language**.
* It runs **on the EC2 server**, not in the browser.
* It lets the website **change automatically** each time the page loads.
* S3 **cannot** run PHP, so S3 sites are always **static**.

---

## 📦 What You Will Build

You will change your EC2 website so it shows:

* The **current server time**
* Content that updates every refresh
* A clear example of “dynamic website”

---

## 🛠️ 1. Install PHP on EC2

Connect to your EC2 instance and run:

```bash
sudo yum install -y php
sudo systemctl restart httpd
```

This installs PHP and restarts Apache so it can use it.

---

## 🗂️ 2. Change Your Main File to PHP

Move into the web folder:

```bash
cd /var/www/html
```

Rename your file:

```bash
sudo mv index.html index.php
```

Now Apache will process the page using PHP.

---

## 🖥️ 3. Add Dynamic PHP Code

Open the file:

```bash
sudo nano index.php
```

Paste:

```php
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My EC2 Dynamic Site</title>
</head>
<body>
  <h1>Hello from EC2!</h1>

  <h2>Dynamic Server Time</h2>
  <p>The current server time is:
     <strong><?php echo date('Y-m-d H:i:s'); ?></strong>
  </p>

  <h2>Why This Is Different From S3</h2>
  <ul>
    <li>The time above changes every refresh.</li>
    <li>It is created by PHP running on the server.</li>
    <li>S3 cannot run server code, so S3 cannot do this.</li>
  </ul>
</body>
</html>
```

Save and exit:

* **Ctrl + O**
* **Enter**
* **Ctrl + X**

---

## 🌍 4. Test Your Dynamic Site

Open your EC2 **public IP address** in your web browser.

You should now see:

* The server time
* It updates every time you refresh
* A true “dynamic” EC2 website

---

## 🔍 The Difference (Very Simple)

| Feature                       | S3 Website | EC2 Website |
| ----------------------------- | ---------- | ----------- |
| Runs code (PHP, Python, etc.) | ❌ No       | ✅ Yes       |
| Can update by itself          | ❌ No       | ✅ Yes       |
| Good for static sites         | ✅ Yes      | ✔️ Yes      |
| Good for apps                 | ❌ No       | ✔️ Yes      |

---

## 🚀 What You Can Add Next

If you want more dynamic features, we can add:

* A live **visitor counter**
* A simple **text form**
* A **random number generator**
* A **simple login page**
* A **mini API**

Just say **“let’s add feature X”**.

---