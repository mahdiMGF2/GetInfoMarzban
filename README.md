پیش نیاز ها 
<br>php 7.4_8
<br>وب سرور برای اجرایphp
<br> V dev marzban
<br> install panel marzban use docker
<br> server os ubuntu

 روی هاست نمی توان نصب کرد


ابتدا باید api  پنل مرزبان را فعال کنید برای فعال کردن api  پنل مرزبان  به مسیر /root/marzban  رفته و فایل env را باز کرده و کد زیر را درون فایل (آخر خط ) قرار داده و فایل را ذخیره کنید.
```bash
DOCS = True
```
سپس  به صفحه ای پی ای پنل مرزبان رفته و توکن ای پی آی را گرفته و داخل فایل config  قرار دهید


بعد از فعال کردن api  پنل باید php  و وب سرور را روی سرورتان نصب کنید تا بتوانید فایل ها را اجرا کنید برای نصب دستورات زیر را بزنید 

# نصب پیش نیاز ها
```bash
sudo apt update
sudo apt uprgade -y
sudo apt install php 
```
نصب وب سرور آپاچی ( میتوانید از وب سرور های دیگه استفاده کنید )

```bash
sudo apt install apache2

```
در صورت استفاده از وب سرور آپاچی بعد از نصب php  دستور زیر را اجرا کنید
```bash
sudo systemctl restart apache2

```


