# 🌐 Cloudinary Setup Guide

## Step 1: Create Cloudinary Account

1. Go to [https://cloudinary.com](https://cloudinary.com)
2. Click "Sign Up For Free"
3. Choose the **Free Plan** (25GB storage, 25GB bandwidth/month)
4. Complete the registration

## Step 2: Get Your API Credentials

1. After logging in, go to your **Dashboard**
2. You'll see your **Cloud Name**, **API Key**, and **API Secret**
3. Copy these values - you'll need them for your Laravel app

## Step 3: Configure Laravel Environment

Add these to your `.env` file:

```env
# Cloudinary Configuration
CLOUDINARY_CLOUD_NAME=your_cloud_name_here
CLOUDINARY_API_KEY=your_api_key_here
CLOUDINARY_API_SECRET=your_api_secret_here
CLOUDINARY_URL=cloudinary://your_api_key:your_api_secret@your_cloud_name
```

## Step 4: Test Your Setup

1. Run your Laravel application: `php artisan serve`
2. Go to `/admin/file-manager` (you need to be logged in as admin)
3. Try uploading an image or document
4. Check if files appear in your Cloudinary dashboard

## 🚀 Features Available

### Image Upload
- **Supported formats**: JPEG, PNG, JPG, GIF, WebP
- **Max size**: 10MB
- **Auto optimization**: Images are automatically optimized
- **Transformations**: Resize, change format, adjust quality

### Document Upload
- **Supported formats**: PDF, DOC, DOCX, TXT
- **Max size**: 10MB
- **Secure storage**: Files are stored securely in the cloud

### File Management
- **View files**: Click "View" to see your uploaded files
- **Copy URLs**: Click "Copy URL" to get the direct link
- **Delete files**: Remove files you no longer need
- **Transform images**: Change size, format, and quality

## 📁 File Organization

Files are organized in folders:
- **Images**: `portfolio/images/`
- **Documents**: `portfolio/documents/`

## 🔧 API Endpoints

Your Laravel app now has these API endpoints:

- `POST /api/upload/image` - Upload images
- `POST /api/upload/document` - Upload documents
- `DELETE /api/upload/file` - Delete files
- `GET /api/upload/file-info` - Get file information
- `POST /api/upload/transform` - Transform images

## 💡 Usage Tips

1. **Image Optimization**: Cloudinary automatically optimizes images for web delivery
2. **CDN**: All files are served through Cloudinary's global CDN for fast loading
3. **Transformations**: You can resize images on-the-fly by modifying the URL
4. **Backup**: Your files are safely stored in the cloud with automatic backups

## 🆓 Free Tier Limits

- **Storage**: 25GB
- **Bandwidth**: 25GB/month
- **Transformations**: 25,000/month
- **Uploads**: 1,000/month

## 🔒 Security

- All uploads are validated for file type and size
- Files are stored securely in your private Cloudinary account
- URLs can be made private if needed

## 🆘 Troubleshooting

### Common Issues:

1. **"Invalid credentials"**: Check your `.env` file has the correct API keys
2. **"File too large"**: Reduce file size or upgrade your plan
3. **"Invalid file type"**: Check the supported formats list
4. **"Upload failed"**: Check your internet connection and try again

### Getting Help:

- Check the [Cloudinary Documentation](https://cloudinary.com/documentation)
- Visit the [Cloudinary Community Forum](https://support.cloudinary.com/hc/en-us/community/topics)
- Contact Cloudinary Support if you have account issues

## 🎉 You're All Set!

Your portfolio now has professional cloud file storage! Upload your images and documents, and they'll be served fast from Cloudinary's global CDN.
