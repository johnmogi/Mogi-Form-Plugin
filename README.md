# **Mogi Form Plugin**

A simple yet powerful WordPress contact form plugin designed for developers and users who seek flexibility, ease of use, and extendability. Mogi Form allows you to create, manage, and customize forms effortlessly through a user-friendly admin interface.

---

## **Features**
- **Form Management:**
  - Create and edit forms with PHP templates.
  - Duplicate or delete forms with ease.
  - View form submissions directly in the admin panel.
- **Shortcode Support:**
  - Embed forms anywhere on your site using shortcodes (e.g., `[mogi_form id="1"]`).
- **Admin-Friendly Interface:**
  - Simple and intuitive admin settings page.
  - View form-specific statistics, such as the number of submissions.
- **Form Submissions:**
  - Save submissions to the database with export options (CSV/JSON).
  - Email notifications for new submissions.
- **AJAX Submission:**
  - Smooth, reload-free form submission for enhanced user experience.
- **Styling Options:**
  - Built-in basic CSS for clean and professional forms.

---

## **Installation**

### **Step 1: Upload the Plugin**
1. Download the plugin files.
2. Go to your WordPress admin panel.
3. Navigate to **Plugins** > **Add New** > **Upload Plugin**.
4. Upload the `mogi-form.zip` file and click **Install Now**.

### **Step 2: Activate the Plugin**
1. After installation, click **Activate Plugin**.
2. The plugin will add a "Mogi Forms" menu to your WordPress admin panel.

---

## **Usage**

### **1. Create a New Form**
1. Go to **Mogi Forms** > **Forms** in the WordPress admin.
2. Click the **Add New Form** button.
3. A new PHP template file will be created under `/wp-content/plugins/mogi-form/forms/`.
4. Edit the template to customize the form structure and behavior.

### **2. Embed a Form**
Use the shortcode `[mogi_form id="1"]` to display a form on any page or post. Replace `1` with the ID of your form.

### **3. Manage Submissions**
1. View submissions by clicking the **View Submissions** link next to each form in the admin panel.
2. Export submissions in CSV or JSON format for external use.

---

## **Customization**

### **Editing Form Templates**
- Navigate to `/wp-content/plugins/mogi-form/forms/`.
- Open the desired `form-{id}.php` file in a code editor.
- Customize the form fields and layout as needed.

### **Styling**
1. Use the `form.css` file under `/assets/css/` to customize the form's appearance globally.
2. For admin-specific styles, modify `admin.css`.

---

## **Shortcode Attributes**
- **Basic Usage:** `[mogi_form id="1"]`
- **Customization:** Add additional attributes as needed (future updates will support custom styles).

---

## **Future Enhancements**
1. **Google She
