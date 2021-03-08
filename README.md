<!--
*** Thanks for checking out the Best-README-Template. If you have a suggestion
*** that would make this better, please fork the repo and create a pull request
*** or simply open an issue with the tag "enhancement".
*** Thanks again! Now go create something AMAZING! :D
-->



<!-- PROJECT SHIELDS -->
<!--
*** I'm using markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Build](https://github.com/dombidav/dombi-tibor-szakdolgozat/actions/workflows/laravel.yml/badge.svg?branch=master)](https://github.com/dombidav/dombi-tibor-szakdolgozat/actions/workflows/laravel.yml)



<!-- PROJECT LOGO -->
<br />
<p align="center">
  <a href="https://github.com/dombidav/dombi-tibor-szakdolgozat">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" alt="Logo" width="800" height="200">
  </a>

<h3 align="center">Webservice for Managed Access Control Systems</h3>

  <p align="center">
    Dombi Tibor Dávid Thesis Work <br />
    Eszterházy Károly University, Hungary
    <br />
    <a href="https://github.com/dombidav/dombi-tibor-szakdolgozat/wiki"><strong>Explore the docs »</strong></a>
    <br />
    <br />

[comment]: <> (    <a href="https://github.com/dombidav/dombi-tibor-szakdolgozat">View Demo</a>)

[comment]: <> (    ·)

[comment]: <> (    <a href="https://github.com/dombidav/dombi-tibor-szakdolgozat/issues">Report Bug</a>)

[comment]: <> (    ·)

[comment]: <> (    <a href="https://github.com/dombidav/dombi-tibor-szakdolgozat/issues">Request Feature</a>)
  </p>



<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary><h2 style="display: inline-block">Table of Contents</h2></summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#license">License</a></li>
    <li><a href="#acknowledgements">Acknowledgements</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

This project is a base for a managed access control system webservice


### Built With

* [Laravel](https://github.com/laravel/laravel)
* [Fortify](https://github.com/laravel/fortify)
* [Vue.js](https://github.com/vuejs/vue)



<!-- GETTING STARTED -->
## Getting Started

To get a local copy up and running follow these simple steps.

### Prerequisites

* PHP 7.4 or newer (this repository is PHP 8 compatible)
* [Composer](https://getcomposer.org/)
* Database of your choice (MySQL, SQLite)
* Optional: [XDebug](https://xdebug.org/wizard) for testing

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/dombidav/dombi-tibor-szakdolgozat.git
   ```
2. Install Composer packages
   ```sh
   composer install
   ```
3. Copy `.env.example` to `.env`
    ```sh
   cp '.env.example' '.env'
    ```
4. Generate APP KEY:
    ```sh
   php artisan key:generate
    ```
5. Run migrations and database seeders:
    ```sh
   php artisan migrate:fresh --seed
    ```
6. Run tests:
    ```sh
   php artisan test
    ```

<!-- LICENSE -->
## License

Distributed under the MIT License. See [`LICENSE`](https://raw.githubusercontent.com/dombidav/dombi-tibor-szakdolgozat/master/LICENSE.md) for more information.



<!-- CONTACT -->

Project Link: [https://github.com/dombidav/dombi-tibor-szakdolgozat](https://github.com/dombidav/dombi-tibor-szakdolgozat)



<!-- ACKNOWLEDGEMENTS -->
## Acknowledgements

* []()
* []()
* []()
