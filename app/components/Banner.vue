<template>
    <div class="banner">
        <div class="banner-content">
            <h3 class="banner-subtitle">A free and open source Spotify extension</h3>
            <h1 class="banner-title">Collect, organize and 
                analyze your music preferences</h1>
                <div class="actions">
                    <LoginButton title="Try it" />
                    <b-link class="btn btn-secundary" to="/about">About</b-link>
                </div>
        </div>
    </div>
</template>
<style>
    .banner{
        height: 100vh;
        background-image: url(~/assets/img/headphone.jpg);
        background-size: cover;
        position: relative;
        z-index: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .banner-content{
        max-width: 70%;
    }
    .actions{
        z-index: 1 !important;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 3rem;
    }
    .actions .btn{
        margin: 0 1rem;
        border-radius: 500px;
        padding: .5rem 2rem;
    }
    .banner-title, .banner-subtitle{
        color: white;
        text-align: center;
        text-transform: uppercase;
        font-family: 'Raleway', sans-serif;
    }
    .banner-title{
        font-size: 2rem;
        font-weight: 200;
        margin-top: 1rem;
    }
    .banner-subtitle{
        font-size: 1rem;
        font-weight: 200;
    }
     .banner::after{
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background-color: #000000b8;
        width: 100%;
        z-index: -1; 
    }
</style>