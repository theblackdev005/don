@extends('layouts.dashboard')

@section('title', config('site.name').' | Mon compte')

@section('body-class', 'bg-secondary')

@push('meta')
  @include('partials.meta-default')
@endpush

@section('content')
<main class="page-wrapper flex-grow-1">
      <!-- Page container -->
      <div class="container py-5 mt-4 mt-lg-5 mb-lg-4 my-xl-5">
        <div class="row pt-sm-2 pt-lg-0">

          <!-- Sidebar (offcanvas on sreens < 992px) -->
          <aside class="col-lg-3 pe-lg-4 pe-xl-5 mt-n3 pt-4 pt-lg-0">
            <div class="position-lg-sticky" style="top: 5.5rem;">
              <div class="offcanvas-lg offcanvas-start" id="sidebarAccount">
                <button class="btn-close position-absolute top-0 end-0 mt-3 me-3 d-lg-none" type="button" data-bs-dismiss="offcanvas" data-bs-target="#sidebarAccount" aria-label="Fermer"></button>
                <div class="offcanvas-body">
                  <div class="pb-2 pb-lg-0 mb-4 mb-lg-5">
                    <img class="d-block rounded-circle mb-2" src="/assets/img/avatar/02.jpg" width="80" alt="Isabella Bocouse">
                    <h3 class="h5 mb-1">Isabella Bocouse</h3>
                    <p class="fs-sm text-body-secondary mb-0">bocouse@example.com</p>
                  </div>
                  <nav class="nav flex-column pb-2 pb-lg-4 mb-3">
                    <h4 class="fs-xs fw-medium text-body-secondary text-uppercase pb-1 mb-2">Compte</h4>
                    <a class="nav-link fw-semibold py-2 px-0 active" href="{{ route('account') }}">
                      <i class="ai-user-check fs-5 opacity-60 me-2"></i>
                      Aperçu
                    </a>
                  </nav>
                  <nav class="nav flex-column">
                    <a class="nav-link fw-semibold py-2 px-0" href="#">
                      <i class="ai-logout fs-5 opacity-60 me-2"></i>
                      Déconnexion
                    </a>
                    <a class="nav-link fw-semibold py-2 px-0" href="{{ url('/') }}">
                      <i class="ai-arrow-left fs-5 opacity-60 me-2"></i>
                      Retour au site
                    </a>
                  </nav>
                </div>
              </div>
            </div>
          </aside>


          <!-- Page content -->
          <div class="col-lg-9 pt-4 pb-2 pb-sm-4">
            <h1 class="h2 mb-4">Aperçu</h1>

            <!-- Basic info -->
            <section class="card border-0 py-1 p-md-2 p-xl-3 p-xxl-4 mb-4">
              <div class="card-body">
                <div class="d-flex align-items-center mt-sm-n1 pb-4 mb-0 mb-lg-1 mb-xl-3">
                  <i class="ai-user text-primary lead pe-1 me-2"></i>
                  <h2 class="h4 mb-0">Informations personnelles</h2>
                  <a class="btn btn-sm btn-secondary ms-auto" href="#">
                    <i class="ai-edit ms-n1 me-2"></i>
                    Modifier
                  </a>
                </div>
                <div class="d-md-flex align-items-center">
                  <div class="d-sm-flex align-items-center">
                    <img class="rounded-circle flex-shrink-0 object-fit-cover" src="/assets/img/avatar/02.jpg" width="80" height="80" alt="Isabella Bocouse">
                    <div class="pt-3 pt-sm-0 ps-sm-3">
                      <h3 class="h5 mb-2">Isabella Bocouse<i class="ai-circle-check-filled fs-base text-success ms-2"></i></h3>
                      <div class="text-body-secondary fw-medium d-flex flex-wrap flex-sm-nowrap align-items-center">
                        <div class="d-flex align-items-center me-3">
                          <i class="ai-mail me-1"></i>
                          email@example.com
                        </div>
                        <div class="d-flex align-items-center text-nowrap">
                          <i class="ai-map-pin me-1"></i>
                          France
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="w-100 pt-3 pt-md-0 ms-md-auto" style="max-width: 212px;">
                    <div class="d-flex justify-content-between fs-sm pb-1 mb-2">
                      Profil complété
                      <strong class="ms-2">62%</strong>
                    </div>
                    <div class="progress" style="height: 5px;">
                      <div class="progress-bar" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
                <div class="row py-4 mb-2 mb-sm-3">
                  <div class="col-md-6 mb-4 mb-md-0">
                    <table class="table mb-0">
                      <tbody>
                        <tr>
                          <td class="border-0 text-body-secondary py-1 px-0">Téléphone</td>
                          <td class="border-0 text-dark fw-medium py-1 ps-3">+1 234 567 890</td>
                        </tr>
                        <tr>
                          <td class="border-0 text-body-secondary py-1 px-0">Langue</td>
                          <td class="border-0 text-dark fw-medium py-1 ps-3">Français</td>
                        </tr>
                        <tr>
                          <td class="border-0 text-body-secondary py-1 px-0">Genre</td>
                          <td class="border-0 text-dark fw-medium py-1 ps-3">Femme</td>
                        </tr>
                        <tr>
                          <td class="border-0 text-body-secondary py-1 px-0">Contact préféré</td>
                          <td class="border-0 text-dark fw-medium py-1 ps-3">Mobile, e-mail</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-6 d-md-flex justify-content-end">
                    <div class="w-100 border rounded-3 p-4" style="max-width: 212px;">
                      <img class="d-block mb-2" src="/assets/img/account/gift-icon.svg" width="24" alt="Icône points fidélité">
                      <h4 class="h5 lh-base mb-0">123 points fidélité</h4>
                      <p class="fs-sm text-body-secondary mb-0">1 point = 1 €</p>
                    </div>
                  </div>
                </div>
                <div class="alert alert-info d-flex mb-0" role="alert">
                  <i class="ai-circle-info fs-xl"></i>
                  <div class="ps-2">Complétez toutes les informations pour recevoir des offres mieux adaptées.<a class="alert-link ms-1" href="#">Ouvrir les paramètres</a></div>
                </div>
              </div>
            </section>

            <div class="row row-cols-1 row-cols-md-2 g-4 mb-4">


              <!-- Address -->
              <section class="col">
                <div class="card h-100 border-0 py-1 p-md-2 p-xl-3 p-xxl-4">
                  <div class="card-body">
                    <div class="d-flex align-items-center mt-sm-n1 pb-4 mb-1 mb-lg-2">
                      <i class="ai-map-pin text-primary lead pe-1 me-2"></i>
                      <h2 class="h4 mb-0">Adresse</h2>
                      <a class="btn btn-sm btn-secondary ms-auto" href="#">
                        <i class="ai-edit ms-n1 me-2"></i>
                        Modifier
                      </a>
                    </div>
                    <div class="d-flex align-items-center pb-1 mb-2">
                      <h3 class="h6 mb-0 me-3">Adresse de livraison</h3>
                      <span class="badge bg-primary bg-opacity-10 text-primary">Principal</span>
                    </div>
                    <p class="mb-0">401 Magnetic Drive Unit 2,<br>Toronto, Ontario, M3J 3H9<br>Canada</p>
                    <div class="d-flex align-items-center pt-4 pb-1 my-2">
                      <h3 class="h6 mb-0 me-3">Adresse de facturation</h3>
                      <span class="badge bg-primary bg-opacity-10 text-primary">Principal</span>
                    </div>
                    <p class="mb-0">314 Robinson Lane,<br>Wilmington, DE 19805,<br>USA</p>
                  </div>
                </div>
              </section>


              <!-- Billing -->
              <section class="col">
                <div class="card h-100 border-0 py-1 p-md-2 p-xl-3 p-xxl-4">
                  <div class="card-body">
                    <div class="d-flex align-items-center mt-sm-n1 pb-4 mb-1 mb-lg-2">
                      <i class="ai-wallet text-primary lead pe-1 me-2"></i>
                      <h2 class="h4 mb-0">Paiement</h2>
                      <a class="btn btn-sm btn-secondary ms-auto" href="#">
                        <i class="ai-edit ms-n1 me-2"></i>
                        Modifier
                      </a>
                    </div>
                    <div class="d-flex align-items-center pb-1 mb-2">
                      <h3 class="h6 mb-0 me-3">Isabella Bocouse</h3>
                      <span class="badge bg-primary bg-opacity-10 text-primary">Principal</span>
                    </div>
                    <div class="d-flex align-items-center pb-4 mb-2 mb-sm-3">
                      <svg width="52" height="42" viewBox="0 0 52 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.6402 28.2865H18.5199L21.095 12.7244H25.2157L22.6402 28.2865ZM15.0536 12.7244L11.1255 23.4281L10.6607 21.1232L10.6611 21.124L9.27467 14.1256C9.27467 14.1256 9.10703 12.7244 7.32014 12.7244H0.8262L0.75 12.9879C0.75 12.9879 2.73586 13.3942 5.05996 14.7666L8.63967 28.2869H12.9327L19.488 12.7244H15.0536ZM47.4619 28.2865H51.2453L47.9466 12.7239H44.6345C43.105 12.7239 42.7324 13.8837 42.7324 13.8837L36.5873 28.2865H40.8825L41.7414 25.9749H46.9793L47.4619 28.2865ZM42.928 22.7817L45.093 16.9579L46.3109 22.7817H42.928ZM36.9095 16.4667L37.4975 13.1248C37.4975 13.1248 35.6831 12.4463 33.7916 12.4463C31.7469 12.4463 26.8913 13.3251 26.8913 17.5982C26.8913 21.6186 32.5902 21.6685 32.5902 23.7803C32.5902 25.8921 27.4785 25.5137 25.7915 24.182L25.1789 27.6763C25.1789 27.6763 27.0187 28.555 29.8296 28.555C32.6414 28.555 36.8832 27.1234 36.8832 23.2271C36.8832 19.1808 31.1331 18.8041 31.1331 17.0449C31.1335 15.2853 35.1463 15.5113 36.9095 16.4667Z" fill="#2566AF"/>
                        <path d="M10.6611 22.1235L9.2747 15.1251C9.2747 15.1251 9.10705 13.7239 7.32016 13.7239H0.8262L0.75 13.9874C0.75 13.9874 3.87125 14.6235 6.86507 17.0066C9.72766 19.2845 10.6611 22.1235 10.6611 22.1235Z" fill="#E6A540"/>
                      </svg>
                      <div class="ps-3 fs-sm">
                        <div class="text-dark">Visa •••• 9016</div>
                        <div class="text-body-secondary">Débit — expire en 03/24</div>
                      </div>
                    </div>
                    <div class="alert alert-danger d-flex mb-0">
                      <i class="ai-octagon-alert fs-xl me-2"></i>
                      <p class="mb-0">Votre carte principale a expiré le 01/04/2023. Ajoutez une nouvelle carte ou mettez celle-ci à jour.</p>
                    </div>
                  </div>
                </div>
              </section>
            </div>


            <!-- Orders -->
            <section class="card border-0 py-1 p-md-2 p-xl-3 p-xxl-4">
              <div class="card-body">
                <div class="d-flex align-items-center mt-sm-n1 pb-4 mb-0 mb-lg-1 mb-xl-3">
                  <i class="ai-cart text-primary lead pe-1 me-2"></i>
                  <h2 class="h4 mb-0">Commandes</h2>
                  <a class="btn btn-sm btn-secondary ms-auto" href="#">Tout voir</a>
                </div>

                <!-- Orders accordion -->
                <div class="accordion accordion-alt accordion-orders" id="orders">

                  <!-- Order -->
                  <div class="accordion-item border-top mb-0">
                    <div class="accordion-header">
                      <a class="accordion-button d-flex fs-4 fw-normal text-decoration-none py-3 collapsed" href="#orderOne" data-bs-toggle="collapse" aria-expanded="false" aria-controls="orderOne">
                        <div class="d-flex justify-content-between w-100" style="max-width: 440px;">
                          <div class="me-3 me-sm-4">
                            <div class="fs-sm text-body-secondary">#78A6431D409</div>
                            <span class="badge bg-info bg-opacity-10 text-info fs-xs">En cours</span>
                          </div>
                          <div class="me-3 me-sm-4">
                            <div class="d-none d-sm-block fs-sm text-body-secondary mb-2">Date de commande</div>
                            <div class="d-sm-none fs-sm text-body-secondary mb-2">Date</div>
                            <div class="fs-sm fw-medium text-dark">27 janv. 2023</div>
                          </div>
                          <div class="me-3 me-sm-4">
                            <div class="fs-sm text-body-secondary mb-2">Montant total</div>
                            <div class="fs-sm fw-medium text-dark">16,00 €</div>
                          </div>
                        </div>
                        <div class="accordion-button-img d-none d-sm-flex ms-auto">
                          <div class="mx-1">
                            <img src="/assets/img/account/orders/01.png" width="48" alt="Article">
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="accordion-collapse collapse" id="orderOne" data-bs-parent="#orders">
                      <div class="accordion-body">
                        <div class="table-responsive pt-1">
                          <table class="table align-middle w-100" style="min-width: 450px;">
                            <tbody>
                              <tr>
                                <td class="border-0 py-1 px-0">
                                  <div class="d-flex align-items-center">
                                    <a class="d-inline-block flex-shrink-0 bg-secondary rounded-1 p-md-2 p-lg-3" href="#">
                                      <img src="/assets/img/shop/cart/01.png" width="110" alt="Article">
                                    </a>
                                    <div class="ps-3 ps-sm-4">
                                      <h4 class="h6 mb-2">
                                        <a href="#">Bougie décorative en béton</a>
                                      </h4>
                                      <div class="text-body-secondary fs-sm me-3">Couleur : <span class="text-dark fw-medium">Gris nuit</span></div>
                                    </div>
                                  </div>
                                </td>
                                <td class="border-0 py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Quantité</div>
                                  <div class="fs-sm fw-medium text-dark">1</div>
                                </td>
                                <td class="border-0 py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Prix</div>
                                  <div class="fs-sm fw-medium text-dark">16 €</div>
                                </td>
                                <td class="border-0 text-end py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Montant total</div>
                                  <div class="fs-sm fw-medium text-dark">16 €</div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="bg-secondary rounded-1 p-4 my-2">
                          <div class="row">
                            <div class="col-sm-5 col-md-3 col-lg-4 mb-3 mb-md-0">
                              <div class="fs-sm fw-medium text-dark mb-1">Paiement :</div>
                              <div class="fs-sm">À la livraison</div>
                              <a class="btn btn-link py-1 px-0 mt-2" href="#">
                                <i class="ai-time me-2 ms-n1"></i>
                                Historique des commandes
                              </a>
                            </div>
                            <div class="col-sm-7 col-md-5 mb-4 mb-md-0">
                              <div class="fs-sm fw-medium text-dark mb-1">Adresse de livraison :</div>
                              <div class="fs-sm">401 Magnetic Drive Unit 2,<br>Toronto, Ontario, M3J 3H9, Canada</div>
                            </div>
                            <div class="col-md-4 col-lg-3 text-md-end">
                              <button class="btn btn-sm btn-outline-primary w-100 w-md-auto" type="button">
                                <i class="ai-star me-2 ms-n1"></i>
                                Laisser un avis
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Order -->
                  <div class="accordion-item border-top mb-0">
                    <div class="accordion-header">
                      <a class="accordion-button d-flex fs-4 fw-normal text-decoration-none py-3 collapsed" href="#orderTwo" data-bs-toggle="collapse" aria-expanded="false" aria-controls="orderTwo">
                        <div class="d-flex justify-content-between w-100" style="max-width: 440px;">
                          <div class="me-3 me-sm-4">
                            <div class="fs-sm text-body-secondary">#47H76G09F33</div>
                            <span class="badge bg-danger bg-opacity-10 text-danger fs-xs">Annulée</span>
                          </div>
                          <div class="me-3 me-sm-4">
                            <div class="d-none d-sm-block fs-sm text-body-secondary mb-2">Date de commande</div>
                            <div class="d-sm-none fs-sm text-body-secondary mb-2">Date</div>
                            <div class="fs-sm fw-medium text-dark">Sep 14, 2023</div>
                          </div>
                          <div class="me-3 me-sm-4">
                            <div class="fs-sm text-body-secondary mb-2">Montant total</div>
                            <div class="fs-sm fw-medium text-dark">59,00 €</div>
                          </div>
                        </div>
                        <div class="accordion-button-img d-none d-sm-flex ms-auto">
                          <div class="mx-1">
                            <img src="/assets/img/account/orders/02.png" width="48" alt="Article">
                          </div>
                          <div class="mx-1">
                            <img src="/assets/img/account/orders/03.png" width="48" alt="Article">
                          </div>
                          <div class="mx-1">
                            <img src="/assets/img/account/orders/04.png" width="48" alt="Article">
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="accordion-collapse collapse" id="orderTwo" data-bs-parent="#orders">
                      <div class="accordion-body">
                        <div class="table-responsive pt-1">
                          <table class="table align-middle w-100" style="min-width: 450px;">
                            <tbody>
                              <tr>
                                <td class="border-0 py-1 px-0">
                                  <div class="d-flex align-items-center">
                                    <a class="d-inline-block flex-shrink-0 bg-secondary rounded-1 p-md-2 p-lg-3" href="#">
                                      <img src="/assets/img/shop/cart/04.png" width="110" alt="Article">
                                    </a>
                                    <div class="ps-3 ps-sm-4">
                                      <h4 class="h6 mb-2">
                                        <a href="#">Horloge murale analogique</a>
                                      </h4>
                                      <div class="text-body-secondary fs-sm me-3">Couleur : <span class="text-dark fw-medium">Turquoise</span></div>
                                    </div>
                                  </div>
                                </td>
                                <td class="border-0 py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Quantité</div>
                                  <div class="fs-sm fw-medium text-dark">1</div>
                                </td>
                                <td class="border-0 py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Prix</div>
                                  <div class="fs-sm fw-medium text-dark">25 €</div>
                                </td>
                                <td class="border-0 text-end py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Montant total</div>
                                  <div class="fs-sm fw-medium text-dark">25 €</div>
                                </td>
                              </tr>
                              <tr>
                                <td class="border-0 py-1 px-0">
                                  <div class="d-flex align-items-center">
                                    <a class="d-inline-block flex-shrink-0 bg-secondary rounded-1 p-md-2 p-lg-3" href="#">
                                      <img src="/assets/img/shop/cart/05.png" width="110" alt="Article">
                                    </a>
                                    <div class="ps-3 ps-sm-4">
                                      <h4 class="h6 mb-2">
                                        <a href="#">Vase rond laqué</a>
                                      </h4>
                                      <div class="text-body-secondary fs-sm me-3">Couleur : <span class="text-dark fw-medium">Blanc</span></div>
                                    </div>
                                  </div>
                                </td>
                                <td class="border-0 py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Quantité</div>
                                  <div class="fs-sm fw-medium text-dark">1</div>
                                </td>
                                <td class="border-0 py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Prix</div>
                                  <div class="fs-sm fw-medium text-dark">15 €</div>
                                </td>
                                <td class="border-0 text-end py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Montant total</div>
                                  <div class="fs-sm fw-medium text-dark">15 €</div>
                                </td>
                              </tr>
                              <tr>
                                <td class="border-0 py-1 px-0">
                                  <div class="d-flex align-items-center"><a class="d-inline-block flex-shrink-0 bg-secondary rounded-1 p-md-2 p-lg-3" href="#"><img src="/assets/img/shop/cart/06.png" width="110" alt="Article"></a>
                                    <div class="ps-3 ps-sm-4">
                                      <h4 class="h6 mb-2"><a href="#">Pot de fleurs en céramique</a></h4>
                                      <div class="text-body-secondary fs-sm me-3">Couleur : <span class="text-dark fw-medium">Béton gris</span></div>
                                    </div>
                                  </div>
                                </td>
                                <td class="border-0 py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Quantité</div>
                                  <div class="fs-sm fw-medium text-dark">1</div>
                                </td>
                                <td class="border-0 py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Prix</div>
                                  <div class="fs-sm fw-medium text-dark">19 €</div>
                                </td>
                                <td class="border-0 text-end py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Montant total</div>
                                  <div class="fs-sm fw-medium text-dark">19 €</div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="bg-secondary rounded-1 p-4 my-2">
                          <div class="row">
                            <div class="col-sm-5 col-md-3 col-lg-4 mb-3 mb-md-0">
                              <div class="fs-sm fw-medium text-dark mb-1">Paiement :</div>
                              <div class="fs-sm">À la livraison</div>
                              <a class="btn btn-link py-1 px-0 mt-2" href="#">
                                <i class="ai-time me-2 ms-n1"></i>
                                Historique des commandes
                              </a>
                            </div>
                            <div class="col-sm-7 col-md-5 mb-4 mb-md-0">
                              <div class="fs-sm fw-medium text-dark mb-1">Adresse de livraison :</div>
                              <div class="fs-sm">401 Magnetic Drive Unit 2,<br>Toronto, Ontario, M3J 3H9, Canada</div>
                            </div>
                            <div class="col-md-4 col-lg-3 text-md-end">
                              <button class="btn btn-sm btn-outline-primary w-100 w-md-auto" type="button">
                                <i class="ai-star me-2 ms-n1"></i>
                                Laisser un avis
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Order -->
                  <div class="accordion-item border-top mb-0">
                    <div class="accordion-header">
                      <a class="accordion-button fs-4 fw-normal text-decoration-none py-3 collapsed" href="#orderThree" data-bs-toggle="collapse" aria-expanded="false" aria-controls="orderThree">
                        <div class="d-flex justify-content-between w-100" style="max-width: 440px;">
                          <div class="me-3 me-sm-4">
                            <div class="fs-sm text-body-secondary">#34VB5540K83</div><span class="badge bg-primary bg-opacity-10 text-primary fs-xs">Livrée</span>
                          </div>
                          <div class="me-3 me-sm-4">
                            <div class="d-none d-sm-block fs-sm text-body-secondary mb-2">Date de commande</div>
                            <div class="d-sm-none fs-sm text-body-secondary mb-2">Date</div>
                            <div class="fs-sm fw-medium text-dark">10 juill. 2023</div>
                          </div>
                          <div class="me-3 me-sm-4">
                            <div class="fs-sm text-body-secondary mb-2">Montant total</div>
                            <div class="fs-sm fw-medium text-dark">38,00 €</div>
                          </div>
                        </div>
                        <div class="accordion-button-img d-none d-sm-flex ms-auto">
                          <div class="mx-1">
                            <img src="/assets/img/account/orders/01.png" width="48" alt="Article">
                          </div>
                          <div class="mx-1">
                            <img src="/assets/img/account/orders/05.png" width="48" alt="Article">
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="accordion-collapse collapse" id="orderThree" data-bs-parent="#orders">
                      <div class="accordion-body">
                        <div class="table-responsive pt-1">
                          <table class="table align-middle w-100" style="min-width: 450px;">
                            <tbody>
                              <tr>
                                <td class="border-0 py-1 px-0">
                                  <div class="d-flex align-items-center">
                                    <a class="d-inline-block flex-shrink-0 bg-secondary rounded-1 p-md-2 p-lg-3" href="#">
                                      <img src="/assets/img/shop/cart/01.png" width="110" alt="Article">
                                    </a>
                                    <div class="ps-3 ps-sm-4">
                                      <h4 class="h6 mb-2"><a href="#">Bougie décorative en béton</a></h4>
                                      <div class="text-body-secondary fs-sm me-3">Couleur : <span class="text-dark fw-medium">Gris nuit</span></div>
                                    </div>
                                  </div>
                                </td>
                                <td class="border-0 py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Quantité</div>
                                  <div class="fs-sm fw-medium text-dark">1</div>
                                </td>
                                <td class="border-0 py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Prix</div>
                                  <div class="fs-sm fw-medium text-dark">16 €</div>
                                </td>
                                <td class="border-0 text-end py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Montant total</div>
                                  <div class="fs-sm fw-medium text-dark">16 €</div>
                                </td>
                              </tr>
                              <tr>
                                <td class="border-0 py-1 px-0">
                                  <div class="d-flex align-items-center">
                                    <a class="d-inline-block flex-shrink-0 bg-secondary rounded-1 p-md-2 p-lg-3" href="#">
                                      <img src="/assets/img/shop/cart/02.png" width="110" alt="Article">
                                    </a>
                                    <div class="ps-3 ps-sm-4">
                                      <h4 class="h6 mb-2">
                                        <a href="#">Vase en verre</a>
                                      </h4>
                                      <div class="text-body-secondary fs-sm me-3">Couleur : <span class="text-dark fw-medium">Rose</span></div>
                                    </div>
                                  </div>
                                </td>
                                <td class="border-0 py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Quantité</div>
                                  <div class="fs-sm fw-medium text-dark">2</div>
                                </td>
                                <td class="border-0 py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Prix</div>
                                  <div class="fs-sm fw-medium text-dark">11 €</div>
                                </td>
                                <td class="border-0 text-end py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Montant total</div>
                                  <div class="fs-sm fw-medium text-dark">22 €</div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="bg-secondary rounded-1 p-4 my-2">
                          <div class="row">
                            <div class="col-sm-5 col-md-3 col-lg-4 mb-3 mb-md-0">
                              <div class="fs-sm fw-medium text-dark mb-1">Paiement :</div>
                              <div class="fs-sm">À la livraison</div>
                              <a class="btn btn-link py-1 px-0 mt-2" href="#">
                                <i class="ai-time me-2 ms-n1"></i>
                                Historique des commandes
                              </a>
                            </div>
                            <div class="col-sm-7 col-md-5 mb-4 mb-md-0">
                              <div class="fs-sm fw-medium text-dark mb-1">Adresse de livraison :</div>
                              <div class="fs-sm">401 Magnetic Drive Unit 2,<br>Toronto, Ontario, M3J 3H9, Canada</div>
                            </div>
                            <div class="col-md-4 col-lg-3 text-md-end">
                              <button class="btn btn-sm btn-outline-primary w-100 w-md-auto" type="button">
                                <i class="ai-star me-2 ms-n1"></i>
                                Laisser un avis
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Order -->
                  <div class="accordion-item border-top border-bottom mb-0">
                    <div class="accordion-header">
                      <a class="accordion-button d-flex fs-4 fw-normal text-decoration-none py-3 collapsed" href="#orderFour" data-bs-toggle="collapse" aria-expanded="false" aria-controls="orderFour">
                        <div class="d-flex justify-content-between w-100" style="max-width: 440px;">
                          <div class="me-3 me-sm-4">
                            <div class="fs-sm text-body-secondary">#502TR872W2</div>
                            <span class="badge bg-primary bg-opacity-10 text-primary fs-xs">Livrée</span>
                          </div>
                          <div class="me-3 me-sm-4">
                            <div class="d-none d-sm-block fs-sm text-body-secondary mb-2">Date de commande</div>
                            <div class="d-sm-none fs-sm text-body-secondary mb-2">Date</div>
                            <div class="fs-sm fw-medium text-dark">11 mai 2023</div>
                          </div>
                          <div class="me-3 me-sm-4">
                            <div class="fs-sm text-body-secondary mb-2">Montant total</div>
                            <div class="fs-sm fw-medium text-dark">17,00 €</div>
                          </div>
                        </div>
                        <div class="accordion-button-img d-none d-sm-flex ms-auto">
                          <div class="mx-1">
                            <img src="/assets/img/account/orders/06.png" width="48" alt="Article">
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="accordion-collapse collapse" id="orderFour" data-bs-parent="#orders">
                      <div class="accordion-body">
                        <div class="table-responsive pt-1">
                          <table class="table align-middle w-100" style="min-width: 450px;">
                            <tbody>
                              <tr>
                                <td class="border-0 py-1 px-0">
                                  <div class="d-flex align-items-center">
                                    <a class="d-inline-block flex-shrink-0 bg-secondary rounded-1 p-md-2 p-lg-3" href="#">
                                      <img src="/assets/img/shop/cart/07.png" width="110" alt="Article">
                                    </a>
                                    <div class="ps-3 ps-sm-4">
                                      <h4 class="h6 mb-2">
                                        <a href="#">Dispenser for soap</a>
                                      </h4>
                                      <div class="text-body-secondary fs-sm me-3">Couleur : <span class="text-dark fw-medium">White marble</span></div>
                                    </div>
                                  </div>
                                </td>
                                <td class="border-0 py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Quantité</div>
                                  <div class="fs-sm fw-medium text-dark">1</div>
                                </td>
                                <td class="border-0 py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Prix</div>
                                  <div class="fs-sm fw-medium text-dark">17 €</div>
                                </td>
                                <td class="border-0 text-end py-1 pe-0 ps-3 ps-sm-4">
                                  <div class="fs-sm text-body-secondary mb-2">Montant total</div>
                                  <div class="fs-sm fw-medium text-dark">17 €</div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="bg-secondary rounded-1 p-4 my-2">
                          <div class="row">
                            <div class="col-sm-5 col-md-3 col-lg-4 mb-3 mb-md-0">
                              <div class="fs-sm fw-medium text-dark mb-1">Paiement :</div>
                              <div class="fs-sm">À la livraison</div>
                              <a class="btn btn-link py-1 px-0 mt-2" href="#">
                                <i class="ai-time me-2 ms-n1"></i>
                                Historique des commandes
                              </a>
                            </div>
                            <div class="col-sm-7 col-md-5 mb-4 mb-md-0">
                              <div class="fs-sm fw-medium text-dark mb-1">Adresse de livraison :</div>
                              <div class="fs-sm">401 Magnetic Drive Unit 2,<br>Toronto, Ontario, M3J 3H9, Canada</div>
                            </div>
                            <div class="col-md-4 col-lg-3 text-md-end">
                              <button class="btn btn-sm btn-outline-primary w-100 w-md-auto" type="button">
                                <i class="ai-star me-2 ms-n1"></i>
                                Laisser un avis
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>

      <!-- Divider for dark mode only -->
      <hr class="d-none d-dark-mode-block">

      <!-- Sidebar toggle button -->
      <button class="d-lg-none btn btn-sm fs-sm btn-primary w-100 rounded-0 fixed-bottom" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarAccount">
        <i class="ai-menu me-2"></i>
        Menu du compte
      </button>
</main>
@endsection
