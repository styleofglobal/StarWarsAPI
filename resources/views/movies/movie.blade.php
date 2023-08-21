@extends('layouts.app')

@section('content')
<style>
    *,
    *::before,
    *::after {
        box-sizing: inherit;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    html {
        font-size: 62.5%;
        box-sizing: border-box;
        --color-primary: #37474f;
        --color-primary-dark: #263238;
        --color-primary-light: #546e7a;
        --color-primary-lighter: #b0bec5;
        --text-color: #fafafa;
        --link-color: #444444;
        --border-color: rgba(176, 190, 197, 0.5);
        --shadow-color: rgba(0, 0, 0, 0.2);
        --shadow-color-dark: rgba(0, 0, 0, 0.25);
    }

    form,
    input,
    button,
    a {
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    }

    button {
        outline: none;
        cursor: pointer;
    }

    h1 {
        font-size: 2.5rem;
        font-weight: 200;
        line-height: 1;
        color: var(--color-primary-dark);
        -webkit-letter-spacing: -0.5px;
        -moz-letter-spacing: -0.5px;
        -ms-letter-spacing: -0.5px;
        letter-spacing: -0.5px;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }

    h2 {
        text-transform: uppercase;
        line-height: 1;
        color: var(--color-primary);
        font-size: 1.2rem;
        font-weight: 700;
    }


    .genre {
        width: 100%;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        padding: 1rem 2rem;
        font-size: 1.2rem;
        font-weight: 600;
        line-height: 1;
        opacity: 0.6;
        color: var(--color-primary-light);
        border-color: var(--color-primary-light);
        border: 1px solid transparent;
        border-radius: 2rem;
        -webkit-text-decoration: none;
        text-decoration: none;
        cursor: pointer;
        -webkit-transition: all 100ms cubic-bezier(0.075, 0.82, 0.165, 1);
        transition: all 100ms cubic-bezier(0.075, 0.82, 0.165, 1);
    }

    .genre:hover {
        border: 1px solid;
    }

    .active {
        width: 100%;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        padding: 1rem 2rem;
        font-size: 1.2rem;
        font-weight: 600;
        line-height: 1;
        opacity: 1;
        color: var(--color-primary-dark);
        border-color: var(--color-primary-dark);
        border: 1px solid;
        border-radius: 2rem;
        -webkit-text-decoration: none;
        text-decoration: none;
        cursor: pointer;
        -webkit-transition: all 100ms cubic-bezier(0.075, 0.82, 0.165, 1);
        transition: all 100ms cubic-bezier(0.075, 0.82, 0.165, 1);
    }

    .sidebar-container {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
        width: 25rem;
        padding: 2rem;
        margin-top: 4rem;
        color: var(--color-primary-dark);
        border-right: 1px solid var(--border-color);
    }

    .title-genre {
        font-weight: 700;
        font-size: 1.1rem;
        text-transform: uppercase;
        -webkit-letter-spacing: -0.5px;
        -moz-letter-spacing: -0.5px;
        -ms-letter-spacing: -0.5px;
        letter-spacing: -0.5px;
        margin: 0 0 1rem 1rem;
    }

    .title-genre:not(:first-child) {
        margin-top: 4rem;
    }

    .category-link {
        -webkit-text-decoration: none;
        text-decoration: none;
        display: block;
        outline: none;
        margin-bottom: 0.5rem;
    }

    .category-link.current {
        color: var(--color-primary-dark);
        border-color: var(--color-primary-dark);
        border: 1px solid;
        border-radius: 2rem;
        -webkit-text-decoration: none;
    }

    .search-form {
        position: relative;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        box-shadow: 0 4px 8px var(--shadow-color);
        background-color: var(--color-primary-dark);
        border: 1px solid var(--color-primary);
        width: 2rem;
        cursor: pointer;
        padding: 2rem;
        height: 2rem;
        outline: none;
        border-radius: 10rem;
        -webkit-transition: all 300ms cubic-bezier(0.645, 0.045, 0.355, 1);
        transition: all 300ms cubic-bezier(0.645, 0.045, 0.355, 1);
    }

    .search-form:hover {
        position: relative;
        display: flex;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        justify-content: center;
        box-shadow: 0 4px 8px var(--shadow-color);
        background-color: var(--color-primary-dark);
        border: 1px solid var(--color-primary);
        width: 30rem;
        cursor: auto;
        padding: 2rem;
        height: 2rem;
        outline: none;
        border-radius: 10rem;
        transition: all 300ms cubic-bezier(0.645, 0.045, 0.355, 1) 0s;
    }

    .search-input {
        font-size: 14px;
        line-height: 1;
        font-weight: 300;
        background-color: transparent;
        width: 100%;
        margin-left: 0rem;
        color: var(--text-color);
        border: none;
        -webkit-transition: all 300ms cubic-bezier(0.645, 0.045, 0.355, 1);
        transition: all 300ms cubic-bezier(0.645, 0.045, 0.355, 1);
    }

    .search-input:focus,
    .search-input:active {
        outline: none;
    }

    .search-input::-webkit-input-placeholder {
        color: var(--text-color);
    }

    .search-input::-moz-placeholder {
        color: var(--text-color);
    }

    .search-input:-ms-input-placeholder {
        color: var(--text-color);
    }

    .search-button {
        line-height: 1;
        pointer-events: none;
        cursor: none;
        background-color: transparent;
        border: none;
        outline: none;
        color: var(--text-color);
    }

    .titles {
        margin-bottom: 2rem;
    }

    .link {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-text-decoration: none;
        text-decoration: none;
        background-color: transparent;
        border-radius: 0.8rem;
        -webkit-transition: all 300ms cubic-bezier(0.645, 0.045, 0.355, 1);
        transition: all 300ms cubic-bezier(0.645, 0.045, 0.355, 1);
        position: relative;
        -webkit-transition: all 300ms cubic-bezier(0.215, 0.61, 0.355, 1);
        transition: all 300ms cubic-bezier(0.215, 0.61, 0.355, 1);
    }

    .link:hover {
        -webkit-transform: scale(1.03);
        -ms-transform: scale(1.03);
        transform: scale(1.03);
    }

    .link:hover::after {
        -webkit-transform: scaleY(1);
        -ms-transform: scaleY(1);
        transform: scaleY(1);
        opacity: 1;
    }

    .link::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 0.8rem;
        -webkit-transform: scaleY(0);
        -ms-transform: scaleY(0);
        transform: scaleY(0);
        -webkit-transform-origin: top;
        -ms-transform-origin: top;
        transform-origin: top;
        opacity: 0;
        background-color: var(--color-primary);
        z-index: -99;
        box-shadow: 0rem 2rem 5rem var(--shadow-color-dark);
        -webkit-transition: all 100ms cubic-bezier(0.215, 0.61, 0.355, 1);
        transition: all 100ms cubic-bezier(0.215, 0.61, 0.355, 1);
    }

    .image {
        width: 100%;
        height: 38rem;
        object-fit: cover;
        border-radius: 0.8rem;
        box-shadow: 0rem 2rem 5rem var(--shadow-color);
        -webkit-transition: all 100ms cubic-bezier(0.645, 0.045, 0.355, 1);
        transition: all 100ms cubic-bezier(0.645, 0.045, 0.355, 1);
    }

    .item:hover .image {
        border-radius: 0.8rem 0.8rem 0rem 0rem;
        box-shadow: none;
    }

    .item-title {
        text-align: center;
        font-size: 1.3rem;
        font-weight: 400;
        color: var(--color-primary-light);
        margin-bottom: 1rem;
        line-height: 1.4;
        -webkit-transition: color 300ms cubic-bezier(0.645, 0.045, 0.355, 1);
        transition: color 300ms cubic-bezier(0.645, 0.045, 0.355, 1);
    }

    .item:hover .item-title {
        color: var(--text-color);
    }

    .item-inner {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-pack: justify;
        -webkit-justify-content: space-between;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -webkit-align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        padding: 1.5rem 3rem;
    }

    .item:hover {
        color: var(--color-primary-lighter);
    }

    .rating {
        text-align: center;
        font-size: 1.3rem;
        font-weight: 400;
        color: var(--color-primary-light);
        margin-bottom: 1rem;
        line-height: 1.4;
        -webkit-transition: color 300ms cubic-bezier(0.645, 0.045, 0.355, 1);
        transition: color 300ms cubic-bezier(0.645, 0.045, 0.355, 1);
    }

    .item:hover .rating {
        color: var(--text-color);
    }

    .load-more {
        text-align: center;
        font-size: 30px;
        cursor: pointer;
    }

    .item-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(10rem, 25rem));
        -webkit-box-pack: space-evenly;
        -webkit-justify-content: space-evenly;
        -ms-flex-pack: space-evenly;
        justify-content: space-evenly;
        -webkit-align-content: space-between;
        -ms-flex-line-pack: space-between;
        align-content: space-between;
        -webkit-align-items: start;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: start;
        padding: 4rem 0;
        grid-gap: 4rem 2rem;
    }

    .inner-container {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        width: 100%;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
    }

    .main {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-flex-direction: row;
        -ms-flex-direction: row;
        flex-direction: row;
        position: relative;
        -webkit-align-items: flex-start;
        -webkit-box-align: flex-start;
        -ms-flex-align: flex-start;
        align-items: flex-start;
        height: 100%;
        width: 100%;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .single {
        display: flex;
        flex-direction: column;
        position: relative;
        align-items: flex-start;
        height: 100%;
        width: 100%;
        user-select: none;
        margin: 0px;
        padding: 0px;
    }

    .content {
        width: 100%;
        height: 100%;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        justify-content: center;
        padding: 6rem 4rem;
    }

    .search {
        position: absolute;
        top: 0;
        right: 0;
        padding: 2rem;
    }

    .hide {
        display: none;
    }

    .movie-container {
        width: 100%;
        height: 100%;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        padding: 6rem 4rem;
    }

    .movie-inner {
        display: flex;
        width: 100%;
        flex-direction: column;
    }

    .movie-content {
        display: flex;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        justify-content: center;
        width: 100%;
        max-width: 120rem;
        margin: 0px auto 7rem;
        transition: all 600ms cubic-bezier(0.215, 0.61, 0.355, 1) 0s;
    }

    .movie-poster {
        flex: 1 1 40%;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        justify-content: center;
        display: flex;
    }

    .movie-img {
        max-height: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 0.8rem;
        box-shadow: 0rem 2rem 5rem var(--shadow-color-dark);
    }

    .movie-title {
        font-size: 4rem;
        font-weight: 200;
        line-height: 1.2;
        color: var(--color-primary-dark);
        letter-spacing: -0.5px;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }

    .movie-subdata {
        display: flex;
        -webkit-box-align: center;
        align-items: center;
        margin-bottom: 5rem;
    }

    .movie-data {
        width: 100%;
        max-width: 60%;
        padding: 4rem;
        flex: 1 1 60%;
    }

    .movie-head {
        margin-bottom: 2rem;
    }

    .movie-tagline {
        text-transform: uppercase;
        line-height: 1.5;
        color: var(--color-primary);
        font-size: 1.7rem;
        font-weight: 700;
    }

    .movie-stars {
        font-size: 1.3rem;
        line-height: 1;
        font-weight: 700;
        color: var(--color-primary);
    }

    .movie-left {
        display: flex;
        -webkit-box-align: center;
        align-items: center;
        margin-right: auto;
    }

    .movie-right {
        font-weight: 700;
        line-height: 1;
        text-transform: uppercase;
        color: var(--color-primary-lighter);
        font-size: 1.3rem;
    }

    .movie-fields {
        color: var(--color-primary-dark);
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 1rem;
        font-size: 1.4rem;
    }

    .movie-tags {
        display: flex;
        -webkit-box-align: center;
        align-items: center;
        margin-bottom: 3rem;
        flex-wrap: wrap;
    }

    .movie-taxonomy {
        text-decoration: none;
        display: flex;
        -webkit-box-align: center;
        align-items: center;
        font-size: 1.1rem;
        font-weight: 700;
        line-height: 1;
        color: var(--color-primary-light);
        text-transform: uppercase;
        padding: 0.5rem 0rem;
        transition: all 300ms cubic-bezier(0.075, 0.82, 0.165, 1) 0s;
    }

    .movie-taxonomy:not(:last-child) {
        margin-right: 2rem;
    }

    .movie-taxonomy:active {
        transform: translateY(2px);
    }

    .movie-taxonomy:hover {
        transform: translateY(-3px);
    }

    .movie-description {
        font-size: 1.4rem;
        line-height: 1.8;
        color: var(--link-color);
        font-weight: 500;
        margin-bottom: 3rem;
    }

    .coffee {
        display: -webkit-box !important;
        display: -webkit-flex !important;
        display: -ms-flexbox !important;
        display: flex !important;
        outline: none;
        -webkit-box-pack: center !important;
        -webkit-justify-content: center !important;
        -ms-flex-pack: center !important;
        justify-content: center !important;
        -webkit-align-items: center !important;
        -webkit-box-align: center !important;
        -ms-flex-align: center !important;
        align-items: center !important;
        padding: 0.5rem 2rem;
        color: #000000;
        background-color: #ffffff;
        border-radius: 3px;
        font-family: "Montserrat", sans-serif;
        border: 1px solid transparent;
        -webkit-text-decoration: none;
        text-decoration: none;
        font-family: "Montserrat";
        font-size: 1.2rem;
        -webkit-letter-spacing: 0.6px;
        -moz-letter-spacing: 0.6px;
        -ms-letter-spacing: 0.6px;
        letter-spacing: 0.6px;
        box-shadow: 0px 1px 2px rgba(190, 190, 190, 0.5);
        margin: 2rem auto;
        -webkit-transition: 0.3s all linear;
        transition: 0.3s all linear;
    }

    .coffee:hover,
    .coffee:active,
    .coffee:focus {
        -webkit-text-decoration: none;
        text-decoration: none;
        box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5);
        opacity: 0.85;
        color: #000000;
    }

    .copyright {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-align-self: center;
        -ms-flex-item-align: center;
        align-self: center;
        -webkit-align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        color: var(--color-primary-dark);
    }

    .copyright-link {
        -webkit-text-decoration: none;
        text-decoration: none;
        font-weight: 500;
        margin-left: 4px;
        color: inherit;
    }

    .copyright-img {
        max-width: 100%;
        height: 3rem;
    }

    #myBtn {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 15px;
        z-index: 99;
        font-size: 18px;
        border: none;
        outline: none;
        background-color: rgb(86 86 86 / 36%);
        color: white;
        cursor: pointer;
        padding: 15px;
        border-radius: 1rem;
    }

    #myBtn:hover {
        background-color: #000;
    }

    @media only screen and (max-width: 80em) {
        .sidebar {
            display: none;
        }
    }

    @media only screen and (max-width: 80em) {
        .main {
            display: flex;
            flex-direction: column;
            position: relative;
            align-items: flex-start;
            height: 100%;
            width: 100%;
            user-select: none;
        }
    }

    @media only screen and (max-width: 80em) {
        .search-button {
            color: var(--text-color);
            font-size: 10px;
        }
    }

    @media only screen and (max-width: 37.5em) {
        .search-button {
            color: var(--text-color);
            font-size: 8px;
        }
    }

    @media only screen and (max-width: 56.25em) {
        h1 {
            font-size: 2.2rem;
        }
    }

    @media only screen and (max-width: 37.5em) {
        h1 {
            font-size: 2rem;
        }
    }

    @media only screen and (max-width: 56.25em) {
        h2 {
            font-size: 1.1rem;
        }
    }

    @media only screen and (max-width: 31.25em) {
        .image {
            height: 28rem;
        }
    }

    @media only screen and (max-width: 31.25em) {
        .item-inner {
            padding: 1.5rem 1.5rem;
        }
    }

    @media only screen and (max-width: 80em) {
        .page-button {
            padding: 1.2rem 2rem;
        }
    }

    @media only screen and (max-width: 37.5em) {
        .page-button {
            padding: 1.3rem 1.6rem;
        }
    }

    @media only screen and (max-width: 31.25em) {
        .page-button {
            padding: 1rem 1.3rem;
        }
    }

    @media only screen and (max-width: 37.5em) {
        .item-container {
            grid-template-columns: repeat(auto-fit, minmax(10rem, 23rem));
            -webkit-box-pack: space-around;
            -webkit-justify-content: space-around;
            -ms-flex-pack: space-around;
            justify-content: space-around;
            grid-gap: 4rem 1.5rem;
        }
    }

    @media only screen and (max-width: 31.25em) {
        .item-container {
            grid-template-columns: repeat(auto-fit, minmax(10rem, 18rem));
            grid-gap: 4rem 1rem;
        }
    }

    @media only screen and (max-width: 80em) {
        .search-form {
            background-color: var(--color-primary);
            border: 1px solid transparent;
            padding: 1.5rem;
        }
    }

    @media only screen and (max-width: 25em) {
        .search-form {
            max-width: 25rem;
        }
    }

    @media only screen and (max-width: 80em) {
        .search-input {
            font-size: 13px;
        }
    }

    @media only screen and (max-width: 56.25em) {
        .search-input {
            font-size: 12px;
        }
    }

    @media only screen and (max-width: 56.25em) {
        .overview {
            flex-direction: column;
            margin-bottom: 5rem;
        }
    }

    @media only screen and (max-width: 37.5em) {
        .search-input {
            font-size: 11px;
        }
    }

    @media only screen and (max-width: 90em) {
        .content {
            padding: 6rem 3rem;
        }
    }

    @media only screen and (max-width: 80em) {
        .content {
            padding: 4rem 2rem;
        }
    }

    @media only screen and (max-width: 56.25em) {
        .movie-content {
            flex-direction: column;
            max-width: 110rem !important;
            margin-bottom: 5rem;
        }
    }

    @media only screen and (max-width: 80em) {
        .movie-content {
            max-width: 110rem;
            margin-bottom: 5rem;
        }
    }

    @media only screen and (max-width: 56.25em) {
        .movie-poster {
            max-width: 60%;
            flex: 1 1 60%;
        }
    }

    @media only screen and (max-width: 56.25em) {
        .movie-data {
            max-width: 100% !important;
            flex: 1 1 100%;
        }
    }

    @media only screen and (max-width: 80em) {
        .movie-data {
            padding: 2rem;
        }
    }
</style>
<div class="has-bg-img bg-secondary bg-blend-screen">
    <div class="bg-img bg-cover" style="background-image: url('https://image.tmdb.org/t/p/original{{ $movie->backdrop_path }}'); background-repeat: no-repeat; background-size:100%;color:darkgrey;">
        <div style="padding-top: 22%;"></div>
        <div class="content">
            <div class="inner-container">
                <div class="titles hide">
                    <h1>popular</h1>
                    <h2>movies</h2>
                </div>
                <div class="item-container single">
                    <div class="overview">
                        <div class="movie-container text-dark bg-white">
                            <div class="movie-inner">
                                <div class="movie-content">
                                    <div class="movie-poster"><img class="card-img-top movie-img" alt="{{ $movie->title }}" src="https://image.tmdb.org/t/p/original{{ $movie->poster_path }}"></div>
                                    <div class="movie-data">
                                        <div class="movie-info">
                                            <div class="movie-head">
                                                <h1 class="movie-title">{{ $movie->title }}</h1>
                                                <h1 class="movie-tagline">{{ $movie->tagline }}</h1>
                                            </div>
                                            <div class="movie-subdata">
                                                <div class="movie-left">
                                                    <p class="movie-stars"><i class="fa fa-star" aria-hidden="true"></i> {{ number_format($movie->vote_average,2) }}</p>
                                                </div>
                                                <div class="movie-right">{{ date('Y', strtotime($movie->release_date)) }} / {{ $movie->runtime }} min</div>
                                            </div>
                                            <h3 class="movie-fields">The Genres</h3>
                                            <div class="movie-tags">
                                                @foreach ($genres as $genre)
                                                <a class="movie-taxonomy" href="#">{{$genre->name}}</a>
                                                @endforeach
                                            </div>
                                                <h3 class="movie-fields">The Synopsis</h3>
                                                <p class="movie-description">{{ $movie->overview }}</p>
                                            <h3 class="movie-fields">The Production</h3>
                                            <div class="movie-tags">
                                                @foreach ($productions as $production)
                                                <a class="movie-taxonomy" href="#">{{$production->name}}</a>
                                                @endforeach
                                            </div>
                                            <div id="hideMInfo" class="exit" style="font-size:30px;"><i style="cursor:pointer;" onclick="exit(976573)" class="fa fa-chevron-circle-left" aria-hidden="true"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="load-more"><i class="fa fa-plus-circle more" aria-hidden="true"></i></div>
                </div>
            </div>

        </div>

        @endsection
