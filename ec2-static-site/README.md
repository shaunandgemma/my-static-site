Here’s a complete and corrected **README.md** you can use or upload to GitHub:

---

````markdown
# 🌐 Host a Static Website on Amazon EC2 (Using VS Code + AWS CLI)

This guide explains how to deploy a simple HTML/CSS/JavaScript website to an **EC2 instance** using **Apache**.  
It also includes all the common issues and fixes we encountered along the way.

---

## 🚀 Overview
Unlike S3 (which is fully managed and serverless), EC2 gives you full control over your own web server.  
This setup is great for learning, testing, or when you want to manage dynamic backends yourself.

---

## 1️⃣ Create and Configure Your EC2 Instance

1. Go to **EC2 → Launch instance**  
2. Name: `ec2-static-site`  
3. **AMI:** Amazon Linux 2023  
4. **Instance type:** `t2.micro` (Free Tier)  
5. **Key pair:** Create new → e.g., `ec2-keypair-london` → download `.pem` file and keep it safe  
6. **Security group:**
   - HTTP (port 80) → Source: `0.0.0.0/0`
   - SSH (port 22) → Source: `My IP` *(or 0.0.0.0/0 for testing if your IP changes often)*  
7. Launch the instance.

**⚠️ Note:** If your IP changes often (e.g., home broadband), you’ll lose SSH access unless you allow `0.0.0.0/0` temporarily.

---

## 2️⃣ Connect to the Instance (SSH)

Open a terminal in VS Code (WSL or PowerShell) and navigate to where the `.pem` file is saved.

Fix permissions first:
```bash
chmod 400 ec2-keypair-london.pem
````

Then connect:

```bash
ssh -i "ec2-keypair-london.pem" ec2-user@ec2-xx-xxx-xxx-xxx.eu-west-2.compute.amazonaws.com
```

**Troubleshooting:**

* If connection *times out*: open port 22 in the security group to your current IP.
* If it says *“Permissions too open”*: run `chmod 400` again on the `.pem` file.
* To check your current IP:

  ```bash
  curl ifconfig.me
  ```

---

## 3️⃣ Install Apache on EC2

Once connected:

```bash
sudo dnf -y install httpd
sudo systemctl enable --now httpd
```

Create a quick test page:

```bash
echo '<h1>Hello from EC2</h1>' | sudo tee /var/www/html/index.html
```

Now open your **Public IPv4 DNS** from the EC2 console in your browser —
you should see your test message.

---

## 4️⃣ Upload Your Website Files

On your local machine (where `index.html`, `styles.css`, and `app.js` exist):

1. Make a folder for your EC2 setup, e.g. `ec2-static-site/`
2. Move your `.pem` file there.
3. Run these commands from that folder:

```bash
# Create a folder on EC2
ssh -i ~/.ssh/ec2-keypair-london.pem ec2-user@ec2-xx-xxx-xxx-xxx.eu-west-2.compute.amazonaws.com 'mkdir -p ~/site'

# Copy website files to EC2
scp -i ~/.ssh/ec2-keypair-london.pem index.html styles.css app.js ec2-user@ec2-xx-xxx-xxx-xxx.eu-west-2.compute.amazonaws.com:~/site/
```

Then, in your **EC2 terminal**, move the files into Apache’s web directory:

```bash
sudo mv ~/site/* /var/www/html/
sudo systemctl restart httpd
```

Open your EC2 **Public IPv4 DNS** again in your browser —
your JavaScript site should now appear!

---

## 🧠 Common Pitfalls & Fixes

| Issue                             | Cause                   | Fix                                                         |
| --------------------------------- | ----------------------- | ----------------------------------------------------------- |
| `Connection timed out`            | Your IP changed         | Update SSH rule or allow 0.0.0.0/0 temporarily              |
| `Permissions too open`            | Key file mode > 400     | Run `chmod 400 your-key.pem`                                |
| `No such file or directory` on mv | Files not copied to EC2 | Check scp command and ensure you’re in correct local folder |
| Site loads 403/404                | Wrong file path         | Ensure `index.html` is inside `/var/www/html`               |
| Nothing shows in browser          | Apache not running      | Run `sudo systemctl restart httpd`                          |

---

## ✅ Result

You now have a fully working **EC2-hosted static website** served by Apache.
To make it production-ready, add:

* HTTPS using **AWS Certificate Manager (ACM)** and **Load Balancer**
* A **custom domain** via **Route 53**

---

## 🆚 Bonus: S3 vs EC2 Summary

| Feature           | S3 Static Site      | EC2 Web Server              |
| ----------------- | ------------------- | --------------------------- |
| Server management | None (serverless)   | You manage the OS           |
| HTTPS setup       | Easy via CloudFront | Manual via Load Balancer    |
| Scaling           | Automatic           | You must configure it       |
| Cost              | Very low            | Higher if always running    |
| Good for          | Static files        | Dynamic apps / backend APIs |

---

**Author:** Shaun Estcourt
**Purpose:** AWS SAA-C03 Learning Project – Static Hosting Comparison

```