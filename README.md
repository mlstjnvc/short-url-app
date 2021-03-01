Short Url App
==================================

## Getting started
This is a Laravel framework based application and this setup relies on Homestead with Vagrant and VirtualBox.
Check out this [link](https://laravel.com/docs/8.x/homestead) for reference.

Create a folder named `projects` in your `/home` directory and navigate into it using terminal.

This is how the Homestead.yaml file should look like after a setup.

```
ip: "192.168.10.10"
memory: 3072
cpus: 2
provider: virtualbox

authorize: ~/.ssh/id_rsa.pub

keys:
    - ~/.ssh/id_rsa

folders:
    - map: ~/projects
      to: /home/vagrant/projects

sites:
    - map: short-url-app.local
      to: /home/vagrant/projects/short-url-app/public

databases:
    - short_url_app

features:
    - mysql8:true

backup: true
```
For changes within the file to take effect, you'll need to re-run the provisioners with: `vagrant up --provision`.

After that, add the following line to `/etc/hosts` file and save.

```
192.168.10.10   short-url-app.local
```

Then you need to ssh into the virtual machine using the command `vagrant ssh` and navigate to the
project folder with `cd projects/short-url-app`.

All that is left is to run a couple of basic commands.

```
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
npm install
npm run dev
``` 

### That's it! You should be good to go.
Open `https://short-url-app.local` in browser.

