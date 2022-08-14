# Babylist

## Author
Wouter Tack<br>
For the course Web Development II (2021-2022) Arteveldehogeschool<br>
<br>
## Functionality
1. The admin can scrape categories and products from different websites. He can also view all the products and delete them.<br>

2. When logged in a user can make a wishlist for his baby. THe user has to provide a special code for the wishlist so other people can access his wishlist later on. User can choose different articles that he can add to his wishlist and can also delete articles if user doesn't want them anymore. The user can create multiple wishlists and also delete them if the wishlist is not needed anymore. A logged in user can also acces things the visitor role can do like buying articles from a wishlist.<br>
3. The visitor can access the home page and click on 'Buy gifts from a wishlist', where the user will be asked to enter an access code that someone has given too them. If entered correctly they will be redirected to the wishlist page were they can buy articles from a specific wishlist. There is a shoppingcart integrated in this page, where you can leave your name,e-mail and a little message. Once you click on pay you will be redirected to the payout page from Mollie and once completed you will get a confirmation e-mail from your order.<br>
<br>
## Deployment
<br>
- composer install<br>
- npm install<br>
- add database connection in .env files<br>
- add mailing for SMTP in .env files <br>
- add MOLLIE_KEY in .env files <br> 
- php artisan migrate <br>

- php artisan serve<br>
- npm run dev (if you use vite to render styling)<br>

## Admin
Get access to admin menu by changing your user role to 'admin' in your database <br>

## Hosting
This application is hosted on: http://207.154.248.214/
