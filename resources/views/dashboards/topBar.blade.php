<div class="row header">
    <div class="col-md-6">
        <input class="td-search-field" type="text" placeholder="Search" />
    </div>
    <div class="col-md-6 d-flex align-items-center justify-content-end gap-3">
        <div class="td-notify-bell d-flex align-items-center justify-content-center">
            <img class="img-fluid" src="./assets/images/bell.png" alt="bell-icon" />
        </div>
        <div class="d-flex align-items-center gap-2 td-user">
            <div>
                <img class="img-fluid" src="./assets/images/avatar.png" alt="avatar" />
            </div>
            <div>
                <h3 class="td-username"> {{  Auth::user()->name }} </h3>
                <p class="email"> {{  Auth::user()->email }} </p>
            </div>
        </div>
    </div>
</div>
