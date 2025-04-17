# How to get started locally
1. Install DDEV (https://ddev.com/get-started/)
2. `git clone` this repository inside the environment that contains DDEV (if Windows, will be WSL if you followed the DDEV guide)
3. `cd` into your repository and run `ddev start`
    1. A database dump may be necessary once we start adding in data to the backend (e.g blog posts, videos for example)
4. Run `ddev launch` to launch the website locally
5. If you need to configure something in the backend, you can go to `https://fat-and-badass.ddev.site:8443/admin` and log in.
    1. Let Vince know if you need the admin dashboard credentials

## Create a feature branch
Let's try to keep the history clean(er) and create feature branches so we can squash and merge, unless it's smaller changes
