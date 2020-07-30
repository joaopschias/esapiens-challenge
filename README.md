# eSapiens Challenge

## Let's get started!
To work in the project you going need:

* PHP IDE ([PHPStorm](https://jetbrains.com/phpstorm/), [Visual Studio Code](https://code.visualstudio.com/), [Sublime](https://sublimetext.com/))
* PHP >= 7.2.5
* MySQL >= 5.7
* [Composer](https://getcomposer.org/)
* [Node JS](https://nodejs.org/en/)
* [Oh-My-Zsh](https://github.com/robbyrussell/oh-my-zsh/wiki/Installing-ZSH) (MAC or Linux Terminal)
* [Babun](http://babun.github.io/) (Windows Terminal)
* [Git Flow](https://danielkummer.github.io/git-flow-cheatsheet/index.pt_BR.html)

### Installation
1 - Run on your terminal:

```
git clone git@github.com:cyberschias/esapiens-challenge.git
```

2 - Once the project has been downloaded, go to the project folder.

3 - Create your project's Virtual Host (recommended):

* [Virtual Host Windows using Xampp](http://www.pauloacosta.com/2016/07/criando-multiplos-virtual-hosts-no-xampp/) 
* [Virtual Host Mac OS](https://coolestguidesontheplanet.com/how-to-set-up-virtual-hosts-in-apache-on-macos-osx-sierra/) 

3 - Run on your terminal:

```
composer install 
```
```
npm i && npm run dev
```

4 - After the executions:

* Create the database on your environment. 
* Create your **.env** file in the project root using the **.env.example** file. 
* **Remember to configure the variables related to your database in .env**
* Run on your terminal:
```
php artisan key:generate
```
* Run on your terminal:

```
php artisan migrate --seed
```

5 - Some notes:
* [Postman Docs](https://documenter.getpostman.com/view/6128297/T1DtdujE?version=latest).

## Do you need some help? Contact me!
[João P. Schias](https://www.linkedin.com/in/joaopschias/)
