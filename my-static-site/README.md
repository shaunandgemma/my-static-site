Here’s a simple **README.md** you can use on GitHub:

---

````markdown
# AWS S3 Static Website (Using AWS CLI)

This guide shows how to host a simple JavaScript website on **Amazon S3** using the **AWS CLI**.

---

## 1️⃣ Create Your Website Locally

Create a folder named `my-static-site` and add these files:

- `index.html`
- `styles.css`
- `app.js`

Example:
```html
<h1>Hello from S3!</h1>
<p id="msg"></p>
<script src="app.js"></script>
````

---

## 2️⃣ Configure the AWS CLI

Run this in your terminal and enter your credentials:

```bash
aws configure
```

* Region: `eu-west-2`
* Output: `json`

---

## 3️⃣ Create an S3 Bucket

```bash
aws s3api create-bucket --bucket project-static-website-123 --region eu-west-2 --create-bucket-configuration LocationConstraint=eu-west-2
```

---

## 4️⃣ Enable Static Website Hosting

```bash
aws s3 website s3://project-static-website-123/ --index-document index.html --error-document index.html
```

---

## 5️⃣ Upload Files

From **one level above** your website folder:

```bash
aws s3 sync ./my-static-site s3://project-static-website-123 --delete
```

---

## 6️⃣ Allow Public Access

Turn off Block Public Access:

```bash
aws s3api delete-public-access-block --bucket project-static-website-123
```

Add a read-only bucket policy:

```bash
aws s3api put-bucket-policy --bucket project-static-website-123 --policy '{
  "Version":"2012-10-17",
  "Statement":[{
    "Effect":"Allow",
    "Principal":"*",
    "Action":"s3:GetObject",
    "Resource":"arn:aws:s3:::project-static-website-123/*"
  }]
}'
```

---

## 7️⃣ Test the Website

Open the **Bucket Website Endpoint** from the S3 console:

```
http://project-static-website-123.s3-website.eu-west-2.amazonaws.com
```

If you see “404 NoSuchKey”, make sure `index.html` is at the **root level** of your bucket.

---

## ✅ Result

Your static website is now live on Amazon S3! 🎉