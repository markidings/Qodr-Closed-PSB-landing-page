<!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link active" href="{{ route('home') }}"><i data-feather="home" class="feather-icon"></i><span
                                    class="hide-menu">Dashboard</span></a></li>
                        <li class="list-divider"></li>
                    @if (auth()->user()->isPartner())
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('paket.index') }}" aria-expanded="false">
                                <i class="fas fa-cubes"></i><span class="hide-menu">Paket</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->isAdminCS() || auth()->user()->isAdminSystem())
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('adminPacket.index') }}" aria-expanded="false">
                                <i class="fas fa-cubes"></i><span class="hide-menu">Paket Mitra</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->isPartner())
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('snacks.index') }}" aria-expanded="false">
                                <i class="fas fa-birthday-cake"></i><span class="hide-menu">Menu Tambahan</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->isAdminSystem() || auth()->user()->isPartner() || auth()->user()->isAdminCS())
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                aria-expanded="false"><i class="fas fa-box-open"></i><span
                                    class="hide-menu">List Pemesanan </span></a>
                            <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                @if (auth()->user()->isAdminSystem() || auth()->user()->isAdminCS())
                                <li class="sidebar-item"><a href="{{ route('admin-cs-bookings.index') }}" class="sidebar-link"><span
                                            class="hide-menu">  @if (auth()->user()->isAdminSystem()) Admin CS | @endif Tertunda
                                        </span></a>
                                </li>
                                <li class="sidebar-item"><a href="{{ route('admin-cs-bookings-dp.index') }}" class="sidebar-link"><span
                                            class="hide-menu"> @if (auth()->user()->isAdminSystem()) Admin CS | @endif DP
                                        </span></a>
                                </li>
                                <li class="sidebar-item"><a href="{{ route('report-client.index') }}" class="sidebar-link"><span
                                            class="hide-menu"> @if (auth()->user()->isAdminSystem()) Admin CS | @endif Lunas
                                        </span></a>
                                </li>
                                @endif
                                @if (auth()->user()->isAdminSystem()) <hr> @endif
                                @if (auth()->user()->isAdminSystem() || auth()->user()->isPartner())
                                <li class="sidebar-item"><a href="{{ route('adminbookings.index') }}" class="sidebar-link"><span
                                            class="hide-menu"> @if (auth()->user()->isAdminSystem()) Mitra | @endif Tertunda
                                        </span></a>
                                </li>
                                <li class="sidebar-item"><a href="{{ route('report-partner.index') }}" class="sidebar-link"><span
                                            class="hide-menu"> @if (auth()->user()->isAdminSystem()) Mitra | @endif DP
                                        </span></a>
                                </li>
                                <li class="sidebar-item"><a href="{{ route('report-partner.completed') }}" class="sidebar-link"><span
                                            class="hide-menu"> @if (auth()->user()->isAdminSystem()) Mitra | @endif Lunas
                                        </span></a>
                                </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (auth()->user()->isAdminSystem() || auth()->user()->isAdminCS())
                        <li class="sidebar-item"><a href="{{ route('profitReport.index') }}" class="sidebar-link" aria-expanded="false"><i data-feather="layers" class="feather-icon"></i><span
                                    class="hide-menu"> Laporan Pemasukan
                                </span></a>
                        </li>
                    @endif
                    @if (auth()->user()->isPartner())
                        <li class="sidebar-item"><a href="{{ route('profitReport.indexpartner') }}" class="sidebar-link" aria-expanded="false"><i data-feather="layers" class="feather-icon"></i><span
                                    class="hide-menu"> Laporan Pemasukan
                                </span></a>
                        </li>
                    @endif
                    @if (auth()->user()->isAdminSystem())
                        <li class="sidebar-item">
                            <a class="sidebar-link sidebar-link" href="{{ route('brochures.index') }}"
                                aria-expanded="false"><i data-feather="user" class="feather-icon"></i><span
                                    class="hide-menu">Brosur</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->isPartner())
                        {{-- <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('partnerBookingForm.index')}}" aria-expanded="false">
                                <i class="far fa-clipboard"></i><span class="hide-menu">Transaksi</span>
                            </a>
                        </li> --}}
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="far fa-clipboard"></i><span class="hide-menu">Transaksi</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="{{ route('partnerBookingForm.index') }}" class="sidebar-link">
                                        <span class="hide-menu">Akikahkita</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('partnerBookingForm.show') }}" class="sidebar-link">
                                        <span class="hide-menu">Mandiri</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (
                        auth()->user()->isAdminSystem()
                        || auth()->user()->isAdminCS()
                    )
                        <li class="sidebar-item"><a href="{{ route('purchase-confirms.index') }}" class="sidebar-link" aria-expanded="false"><i data-feather="dollar-sign" class="feather-icon"></i><span
                                    class="hide-menu"> Konfirmasi Bayar
                                </span></a>
                        </li>
                    @endif
                    @if (auth()->user()->isAdminSystem())
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('promos.index') }}" aria-expanded="false">
                                <i class="fas fa-percent"></i>
                                <span class="hide-menu">Promo</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->isAdminSystem())
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('prospects.index') }}" aria-expanded="false">
                                <i data-feather="layers" class="feather-icon"></i>
                                <span class="hide-menu">Prospek</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->isPartner())
                        <li class="sidebar-item">
                            <a href="{{ route('profile-partner') }}" class="sidebar-link" aria-expanded="false">
                                <i data-feather="user" class="feather-icon"></i><span class="hide-menu">Profil</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->isAdminSystem())
                        {{-- Manajemen Users --}}
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fas fa-users"></i><span class="hide-menu">Manajemen Users</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                    <li class="sidebar-item">
                                        <a href="{{ route('user.index') }}" class="sidebar-link">
                                            <span class="hide-menu"> Admin</span>
                                        </a>
                                    </li>
                                @if (auth()->user()->isAdminSystem() || auth()->user()->isAdminCS())
                                    <li class="sidebar-item">
                                        <a href="{{ route('partners.index') }}" class="sidebar-link">
                                            <span class="hide-menu"> Mitra</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('resellers.index') }}" class="sidebar-link">
                                            <span class="hide-menu"> Reseller</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (auth()->user()->isAdminSystem())
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i data-feather="mail" class="feather-icon"></i><span class="hide-menu">Pesan</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="{{ route('message-histories.index') }}" class="sidebar-link">
                                        <span class="hide-menu">History</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('message-templates.index') }}" class="sidebar-link">
                                        <span class="hide-menu">Template</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (auth()->user()->isAdminSystem() || auth()->user()->isAdminCS())
                        <li class="sidebar-item"> <a class="sidebar-link" href="{{ route('broadcast.index') }}"
                                aria-expanded="false"><i data-feather="radio" class="feather-icon"></i><span
                                    class="hide-menu">Broadcast
                                </span></a>
                        </li>
                    @endif
                    @if (auth()->user()->isAdminSystem() || auth()->user()->isAdminCS())
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('cities.index') }}" aria-expanded="false">
                                <i data-feather="map" class="feather-icon"></i>
                                <span class="hide-menu">City</span>
                            </a>
                        </li>
                    @endif

                    @if (
                        auth()->user()->isPartner()
                        || auth()->user()->isAdminCS()
                        || auth()->user()->isAdminSystem()
                    )
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i data-feather="settings" class="feather-icon"></i><span class="hide-menu">Setting</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level base-level-line">

                                @if (auth()->user()->isPartner() )
                                    <li class="sidebar-item">
                                        <a href="{{ route('shipping-cost') }}" class="sidebar-link">
                                            <span class="hide-menu">Biaya Pengiriman</span>
                                        </a>
                                    </li>
                                @endif

                                @if(auth()->user()->isAdminSystem())
                                <li class="sidebar-item">
                                    <a href="{{ route('profitMitra.index') }}" class="sidebar-link">
                                        <span class="hide-menu">Profit Mitra</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('profitReseller') }}" class="sidebar-link">
                                        <span class="hide-menu">Profit Reseller</span>
                                    </a>
                                </li>
                                @endif

                                @if(
                                    auth()->user()->isAdminSystem()
                                    || auth()->user()->isAdminCS()
                                )
                                    <li class="sidebar-item">
                                        <a href="{{ route('setting.bank-account') }}" class="sidebar-link">
                                            <span class="hide-menu">Akun Bank</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
