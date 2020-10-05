<div class="col-lg-4">
    <div class="blog_right_sidebar">
        <aside class="single_sidebar_widget search_widget">
            <form action="<?= url("/blog/buscar"); ?>">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="s" class="form-control" placeholder="Pesquisar">
                        <div class="input-group-append">
                            <button class="btn" type="button"><i class="ti-search"></i></button>
                        </div>
                    </div>
                </div>
                <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn" type="submit">
                    Pesquisar
                </button>
            </form>
        </aside>

        <aside class="single_sidebar_widget newsletter_widget">
            <h4 class="widget_title">Newsletter</h4>
            <form class="ajax_off" target="_blank" action="" id="_form_334_">
                <input type="hidden" name="u" value="334" />
                <input type="hidden" name="f" value="334" />
                <input type="hidden" name="s" />
                <input type="hidden" name="c" value="0" />
                <input type="hidden" name="m" value="0" />
                <input type="hidden" name="act" value="sub" />
                <input type="hidden" name="v" value="2" />
                <div class="form-group">
                    <input type="email" class="form-control" placeholder='Melhor e-mail' required>
                </div>
                <button id="_form_334_submit" class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn" type="submit">
                    QUERO RECEBER
                </button>
            </form>
        </aside>

        <aside class="single_sidebar_widget post_category_widget">
            <h4 class="widget_title">Categorias</h4>
            <ul class="list cat-list">
                <li>
                    <a href="#" class="d-flex">
                        <p>Resaurant food</p>
                        <p>(37)</p>
                    </a>
                </li>
            </ul>
        </aside>

        <aside class="single_sidebar_widget popular_post_widget">
            <h3 class="widget_title">Posts Mais visto</h3>
            <div class="media post_item">
                <img src="<?= asset('assets/img/post/post_1.png"'); ?> alt="post">
                <div class="media-body">
                    <a href="single-blog.html">
                        <h3>From life was you fish...</h3>
                    </a>
                    <p>January 12, 2019</p>
                </div>
            </div>
        </aside>

        <aside class="single_sidebar_widget tag_cloud_widget">
            <h4 class="widget_title">Tags</h4>
            <ul class="list">
                <li>
                    <a href="#">project</a>
                </li>
                <li>
                    <a href="#">love</a>
                </li>
                <li>
                    <a href="#">technology</a>
                </li>
                <li>
                    <a href="#">travel</a>
                </li>
                <li>
                    <a href="#">restaurant</a>
                </li>
                <li>
                    <a href="#">life style</a>
                </li>
                <li>
                    <a href="#">design</a>
                </li>
                <li>
                    <a href="#">illustration</a>
                </li>
            </ul>
        </aside>

        <aside class="single_sidebar_widget instagram_feeds">
            <h4 class="widget_title">Instagram Feeds</h4>
            <ul class="instagram_row flex-wrap">
                <li>
                    <a href="#">
                        <img class="img-fluid" src="<?= asset('assets/img/post/post_5.png"'); ?> alt="">
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img class="img-fluid" src="<?= asset('assets/img/post/post_6.png"'); ?> alt="">
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img class="img-fluid" src="<?= asset('assets/img/post/post_7.png"'); ?> alt="">
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img class="img-fluid" src="<?= asset('assets/img/post/post_8.png"'); ?> alt="">
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img class="img-fluid" src="<?= asset('assets/img/post/post_9.png"'); ?> alt="">
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img class="img-fluid" src="<?= asset('assets/img/post/post_10.png'); ?>" alt="">
                    </a>
                </li>
            </ul>
        </aside>
    </div>
</div>