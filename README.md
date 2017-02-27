Virtual Expo Wordpress Theme used in [virtualexpo.fi](http://www.virtualexpo.fi/).

## Installation instructions

### Prerequisites

* Linux/Unix server
* Wordpress installed on server (4.5.4 tested)
* [ImageMagick](https://www.imagemagick.org/script/index.php) installed on server
* License for plugins:
  * [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/pro/) (Tested on version 5.3.6.1)

### Basic Installation

1. Download and install virtualexpo theme to your wordpress.
2. Install plugins:
  * [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/pro/) (Tested on version 5.3.6.1)
  * [Advanced Custom Fields: Image Crop Add-on](https://wordpress.org/plugins/acf-image-crop-add-on/) (Tested on version 1.4.7)
  * [PDF Image Generator](https://wordpress.org/plugins/pdf-image-generator/) (Tested on version 1.3.9)
  * [User Role Editor](https://wordpress.org/plugins/user-role-editor/) (Tested on version 4.24)
3. Activate theme "Three Dee Expo theme"
4. Activate installed plugins
5. Import Advanced custom Fields:
  * Custom Fields -> Tools -> import field groups -> select `virtual_expo_acf_custom_fields_export.json` -> Press import
6. Display custom post types in admin side:
  * Settings -> User role editor -> select “Show Administrator role at User Role Editor” -> Press Save
7. Create front page:
  1. Pages -> Add New -> Name the page “Front Page” -> Choose template “Front Page” -> Press “publish”
  2. After publish Custom Fields should appear to editor
  3. Enter texts to “About 3D Expo”, “3D Expo Mission” and “Contact Us” fields.
8. Add Front page to static front page
  * Appearance -> Customize -> Static Front Page -> “A static page” -> Select “Front Page” from Front page drop down menu. -> Save & Publish
