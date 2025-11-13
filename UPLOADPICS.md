---

# Static Website Deployment on Amazon S3 (with EC2 Comparison)

This project shows how to build a small static website locally, upload it to **Amazon S3**, and fix common issues you may see.
A matching copy also runs on **EC2** to help compare both hosting methods.

---

## 📁 Project Folder Structure

```
my-static-site/
├── index.html
├── styles.css
├── app.js
└── images/
    ├── Team Selection.jpeg
    └── Team Selection 2.jpeg
```

---

## 📦 What This Project Does

* Hosts a static website on **Amazon S3**
* Adds images to the site and uploads them using the **AWS CLI**
* Fixes common errors (AccessDenied, missing files, wrong paths)
* Shows the difference between updating files locally vs in S3
* Compares the S3 version with a manually deployed EC2 version

---

## 📝 1. Build the Website Locally

Create your files:

* `index.html`
* `styles.css`
* `app.js`
* `images/` folder with your .jpeg files

Example HTML snippet:

```html
<h2>Team Selection</h2>
<img src="images/Team%20Selection.jpeg" width="400">

<h2>Team Selection 2</h2>
<img src="images/Team%20Selection%202.jpeg" width="400">
```

---

## ☁️ 2. Upload the Website to S3

### Enable Static Website Hosting

In the S3 console:

1. Create a bucket
2. Turn off **Block Public Access**
3. Enable **Static Website Hosting**
4. Set `index.html` as the index document

### Upload Files (CLI)

```bash
aws s3 cp index.html s3://YOUR_BUCKET_NAME/index.html
aws s3 cp styles.css s3://YOUR_BUCKET_NAME/styles.css
aws s3 cp app.js s3://YOUR_BUCKET_NAME/app.js
```

### Upload Images (CLI)

```bash
aws s3 cp images/ s3://YOUR_BUCKET_NAME/images/ --recursive
```

---

## 🌍 3. Test the Website

Open:

```
http://YOUR_BUCKET_NAME.s3-website-REGION.amazonaws.com
```

Open images directly to check they load:

```
http://YOUR_BUCKET_NAME.s3-website-REGION.amazonaws.com/images/Team%20Selection.jpeg
```

---

## 🔄 4. How to Update the Website

S3 does **not** sync automatically.
If you change a file locally, upload it again:

```bash
aws s3 cp index.html s3://YOUR_BUCKET_NAME/index.html
```

---

## 🐞 5. Common Errors & Fixes

### ❌ “AccessDenied”

Bucket policy is missing.
Add this (replace bucket name):

```json
{
  "Version": "2012-10-17",
  "Statement": [{
    "Effect": "Allow",
    "Principal": "*",
    "Action": "s3:GetObject",
    "Resource": "arn:aws:s3:::YOUR_BUCKET_NAME/*"
  }]
}
```

---

### ❌ Images Not Showing

Check these:

* File names must match exactly (case-sensitive)
* Spaces need `%20` in the URL
* Image not actually uploaded → run:

```bash
aws s3 ls s3://YOUR_BUCKET_NAME/images/
```

---

### ❌ Website Not Updating

You forgot to re-upload the changed file.

---

## 🖥️ 6. EC2 Version (Optional)

EC2 version steps you used:

1. Launch Amazon Linux EC2 instance
2. Install Apache

   ```bash
   sudo yum install -y httpd
   sudo systemctl start httpd
   sudo systemctl enable httpd
   ```
3. Upload files to server:

   ```bash
   sudo mv ~/site/* /var/www/html/
   ```
4. Visit the public IP to view the site

---

## 🗺️ 7. Simple Architecture Diagram

```
 Local Project
      |
      |  (aws s3 cp)
      v
+-----------------------+
|        S3 Bucket      |
|  - index.html         |
|  - images/*.jpeg      |
|  Public Website Host  |
+-----------------------+
      |
      v
User loads the site via
http://bucket.s3-website-REGION.amazonaws.com
```

---
