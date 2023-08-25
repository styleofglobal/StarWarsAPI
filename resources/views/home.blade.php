@extends('layouts.app')

@section('content')
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        #search-bar {
            float: left;
        }

        .viewbox {
            float: right;
        }

        .clearfix {
            clear: both;
        }

        .view {
            display: inline-block;
        }

        /*listmodel*/
        .lst {
            border-top: 1px solid black;
            border-bottom: 1px solid #d1d1e0;
            padding: 15px;
        }
    </style>

    <!-- data-panel -->
    <div class="container mt-5 ">
        <!--search bar-->
        <div class="row" id="search-bar">
            <form class="form-inline">
                <label class="sr-only" for="inlineFormInputName2">Name</label>
                <input type="text" class="form-control mb-2 mr-sm-2" id="search" placeholder="search name ...">
                <button type="submit" class="btn btn-primary mb-2" id="submit-search">Search</button>
            </form>
        </div>

        <!--veiw-->
        <div class="viewbox  ">
            <div class="view"><i class="fa fa-bars" id="btn-listModel" aria-hidden="true"></i></div>
            <div class="view"><i class="fa fa-th" aria-hidden="true"></i></div>

        </div>

        <div class="clearfix"></div>
        {{ session('_token') }}
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('danger'))
            <div class="alert alert-danger" role="alert">
                {{ session('danger') }}
            </div>
        @endif
        <!-- data-panel -->
        <div class="row" id="data-panel">
            <!-- print movie list here -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="show-movie-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="show-movie-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="show-movie-body">
                    <div class="row">
                        <div class="col-sm-8" id="show-movie-image">
                        </div>
                        <div class="col-sm-4">
                            <p><em id="show-movie-date"></em></p>
                            <p id="show-movie-description"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center" id="pagination">
            <li class="page-item">
                <a class="page-link" href="#">1</a>
            </li>
        </ul>
    </nav>


    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
    </script>
    <script>
        (function() {
            const BASE_URL = "{{ env('APP_URL') }}";
            const INDEX_URL = BASE_URL + "/api/v1/movies/";
            const POSTER_URL = 'https://image.tmdb.org/t/p/original';
            const data = [];

            const dataPanel = document.getElementById("data-panel");
            const searchBtn = document.getElementById("submit-search");
            const searchInput = document.getElementById("search");

            const pagination = document.getElementById("pagination");
            const ITEM_PER_PAGE = 12;
            let paginationData = [];

            const listModel = document.getElementById("btn-listModel");
            const cardModel = document.getElementById("btn-cardModel");

            axios
                .get(INDEX_URL)
                .then(response => {
                    data.push(...response.data.results);
                    getTotalPages(data);
                    // displayDataList(data)
                    getPageData(1, data);
                })
                .catch(err => console.log(err));

            // listen to data panel
            dataPanel.addEventListener("click", event => {
                if (event.target.matches(".btn-show-movie")) {
                    showMovie(event.target.dataset.id);
                } else if (event.target.matches(".btn-add-favorite")) {
                    console.log(event.target.dataset.id);
                    addFavoriteItem(event.target.dataset.id);
                }
            });

            // listen to search btn click event
            searchBtn.addEventListener("click", event => {
                event.preventDefault();
                console.log("click!");

                let results = [];
                const regex = new RegExp(searchInput.value, "i");

                results = data.filter(movie => movie.title.match(regex));
                console.log(results);
                // displayDataList(results)
                getTotalPages(results);
                getPageData(1, results);
            });

            // listen to pagination click event
            pagination.addEventListener("click", event => {
                console.log(event.target.dataset.page);
                if (event.target.matches(".btn-add-favorite")) {
                    getPageData(event.target.dataset.page);
                }
            });

            //listen to viewbox
            listModel.addEventListener("click", event => {
                if (event.target.matches("#btn-listModel")) {
                    displayDataListModel(data);
                }
            });

            function getTotalPages(data) {
                let totalPages = Math.ceil(data.length / ITEM_PER_PAGE) || 1;
                let pageItemContent = "";
                for (let i = 0; i < totalPages; i++) {
                    pageItemContent += `
        <li class="page-item">
          <a class="page-link" href="javascript:;" data-page="${i + 1}">${i +
        1}</a>
        </li>
      `;
                }
                pagination.innerHTML = pageItemContent;
            }

            function getPageData(pageNum, data) {
                paginationData = data || paginationData;
                let offset = (pageNum - 1) * ITEM_PER_PAGE;
                let pageData = paginationData.slice(offset, offset + ITEM_PER_PAGE);
                displayDataList(pageData);
            }

            function getPageDatalistModel(pageNum, data) {
                paginationData = data || paginationData;
                let offset = (pageNum - 1) * ITEM_PER_PAGE;
                let pageData = paginationData.slice(offset, offset + ITEM_PER_PAGE);
                displayDataListModel(pageData);
            }

            function displayDataList(data) {
                let htmlContent = "";
                data.forEach(function(item, index) {
                    htmlContent += `
                            <div class="col-sm-3">
                            <div class="card mb-2">
                                <img class="card-img-top " src="${POSTER_URL}${
                            item.poster_path
                        }" alt="Card image cap">
                                <div class="card-body movie-item-body">
                                <h6 class="card-title">${item.title}</h5>
                                </div>
                                <!-- "More" button -->
                                <div class="card-footer">
                                    <form action="{{ route('movies.destroy', '') }}/${
                                    item.id
                                }" method="POST">
                                <!-- <button class="btn btn-primary btn-show-movie" data-toggle="modal" data-target="#show-movie-modal" data-id="item.id">More</button> -->
                                <a class="btn btn-primary" href="{{ route('movies.show', '') }}/${
                                    item.id
                                }">More</a>
                                <a class="btn btn-primary" href="{{ route('movies.edit', '') }}/${
                                    item.id
                                }">Edit</a>
                                    <!-- favorite button -->
                                <!--<button class="btn btn-info btn-add-favorite" data-id="${
                                    item.id
                                }">+</button>-->

                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="fromweb" value=1 required>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                            </div>
                        `;
                });
                dataPanel.innerHTML = htmlContent;
            }



            function displayDataListModel(data) {
                let htmlContent = "";
                data.forEach(function(item, index) {
                    htmlContent += `
                    <div class="container">
                        <div class="row lst">
                        <div class="col"><h6>${item.title}</h5></div>
                        <div class="col"><button class="btn btn-primary btn-show-movie" data-toggle="modal" data-target="#show-movie-modal"
                            data-id="${item.id}">More</button>
                        <!-- favorite button -->
                        <button class="btn btn-info btn-add-favorite" data-id="${
                            item.id
                        }">+</button></div>
                        </div>
                    </div>`;
                });
                dataPanel.innerHTML = htmlContent;
            }

            function showMovie(id) {
                // get elements
                const modalTitle = document.getElementById("show-movie-title");
                const modalImage = document.getElementById("show-movie-image");
                const modalDate = document.getElementById("show-movie-date");
                const modalDescription = document.getElementById("show-movie-description");

                // set request url
                const url = INDEX_URL + id;
                console.log(url);

                // send request to show api
                axios.get(url).then(response => {
                    // const data = response.data.results;
                    const data = response.data;
                    console.log(data);

                    // insert data into modal ui
                    modalTitle.textContent = data.title;
                    modalImage.innerHTML = `<img src="${POSTER_URL}${
                            data.poster_path
                        }" class="img-fluid" alt="Responsive image">`;
                    modalDate.textContent = `release at : ${data.release_date}`;
                    modalDescription.textContent = `${data.overview}`;
                });
            }

            function addFavoriteItem(id) {
                const list = JSON.parse(localStorage.getItem("favoriteMovies")) || [];
                const movie = data.find(item => item.id === Number(id));

                if (list.some(item => item.id === Number(id))) {
                    alert(`${movie.title} is already in your favorite list.`);
                } else {
                    list.push(movie);
                    alert(`Added ${movie.title} to your favorite list!`);
                }
                localStorage.setItem("favoriteMovies", JSON.stringify(list));
            }
        })();
    </script>
@endsection
