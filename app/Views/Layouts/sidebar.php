<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">HRMnity</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>

            <li class="sidebar-item active">
                <a class="sidebar-link" href="<?= base_url('public/dashboard') ?>">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <!-- <li class="sidebar-item active">
                <a data-bs-target="#dashboards" data-bs-toggle="collapse" class="sidebar-link">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboards</span>
                </a>
                <ul id="dashboards" class="sidebar-dropdown list-unstyled collapse show" data-bs-parent="#sidebar">
                    <li class="sidebar-item active"><a class='sidebar-link' href='<?= base_url('public/empleado/') ?>'>Analytics</a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='/dashboard-ecommerce'>E-Commerce <span
                                class="sidebar-badge badge bg-primary">Pro</span></a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='/dashboard-crypto'>Crypto <span
                                class="sidebar-badge badge bg-primary">Pro</span></a></li>
                </ul>
            </li> -->

            <li class="sidebar-item">
                <a data-bs-target="#personal" data-bs-toggle="collapse" class="sidebar-link">
                    <i class="align-middle" data-feather="users"></i><span class="align-middle">Gestion de
                        personal</span>
                </a>
                <ul id="personal" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class='sidebar-link'
                            href='<?= base_url('public/departamento/') ?>'>Departamento</a></li>
                    <li class="sidebar-item"><a class='sidebar-link'
                            href='<?= base_url('public/empleado/') ?>'>Empleado</a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#reclutamiento" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">Gestion de
                        reclutamiento</span>
                </a>
                <ul id="reclutamiento" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class='sidebar-link'
                            href='<?= base_url('public/vacante') ?>'>Vacantes</a></li>
                    <li class="sidebar-item"><a class='sidebar-link'
                            href='<?=base_url('public/candidato')?>'>candidatos</a></li>
                    <li class="sidebar-item"><a class='sidebar-link'
                            href='<?=base_url('public/entrevista')?>'>Entrevistas</a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#charts" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">Gestion de
                        Nomina</span>
                </a>
                <ul id="charts" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class='sidebar-link' href='<?= base_url('public/salario') ?>'>Salario
                            empleado</a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='<?= base_url('public/nomina') ?>'>Pagar
                            Nomina</a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a class='sidebar-link' href='<?= base_url('public/licencia') ?>'>
                    <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">Licencia</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class='sidebar-link' style="display:none" href='<?= base_url('public/tarea') ?>'>
                    <i class="align-middle" data-feather="clipboard"></i> <span class="align-middle">Tareas</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class='sidebar-link' href='<?= base_url('public/evento') ?>'>
                    <i class="align-middle" data-feather="calendar"></i> <span class="align-middle">Evento</span>
                    
                </a>
            </li>
            <li class="sidebar-item">
                <a class='sidebar-link' style="display:none" href='<?= base_url('public/historial') ?>'>
                    <i class="align-middle" data-feather="clock"></i> <span class="align-middle">Historial</span>
                </a>
            </li>

            <!--             <li class="sidebar-item">
                <a class="sidebar-link" href="pages-sign-in.html">
                    <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Sign In</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="pages-sign-up.html">
                    <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Sign
                        Up</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="pages-blank.html">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">Blank</span>
                </a>
            </li>

            <li class="sidebar-header">
                Tools & Components
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="ui-buttons.html">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Buttons</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="ui-forms.html">
                    <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Forms</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="ui-cards.html">
                    <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Cards</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="ui-typography.html">
                    <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">Typography</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="icons-feather.html">
                    <i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Icons</span>
                </a>
            </li>

            <li class="sidebar-header">
                Plugins & Addons
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="charts-chartjs.html">
                    <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Charts</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="maps-google.html">
                    <i class="align-middle" data-feather="map"></i> <span class="align-middle">Maps</span>
                </a>
            </li>
 -->
        </ul>

    </div>
</nav>