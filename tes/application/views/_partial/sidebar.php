<!-- Sidebar -->
<div class="sidebar sidebar-style-2">
    <?php $level = $this->session->userdata('role_admin'); ?>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="<?= cek_file("uploads/users/" . $foto); ?>" alt="users" class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a href="<?= site_url('dashboard'); ?>">
                        <span>
                            <?= $username; ?>
                            <span class="user-level"><?= $role; ?></span>
                        </span>
                    </a>
                </div>
            </div>
            <ul class="nav nav-primary" style="color: black;">
                <?php
                $this->db->select('a.menu_id, a.menu_link, a.menu_icon, a.menu_name');
                $this->db->join('users_access as b', 'a.menu_id = b.menu_id');
                $this->db->where(['a.is_main_menu' => 0, 'b.role_id' => $level, 'b.akses' => 1]);
                $this->db->order_by('a.urutan ASC');
                $menu = $this->db->get('users_menu as a')->result_array();

                foreach ($menu as $mn) :
                    $this->db->select('a.menu_id, a.menu_link, a.menu_icon, a.menu_name');
                    $this->db->join('users_access as b', 'a.menu_id = b.menu_id');
                    $this->db->where(['a.is_main_menu' => $mn['menu_id'], 'b.role_id' => $level, 'b.akses' => 1]);
                    $this->db->order_by('a.urutan ASC');
                    $submenu = $this->db->get('users_menu as a');
                    if ($submenu->num_rows() == 0) :
                ?>
                        <li class="nav-item <?php if ($mn['menu_link'] == $menu_active) {
                                                echo "active";
                                            } ?>">
                            <a href="<?= site_url($mn['menu_link']); ?>">
                                <i class="<?= $mn['menu_icon']; ?>"></i>
                                <p><?= $mn['menu_name']; ?></p>
                            </a>
                        </li>
                    <?php else : ?>
                        <?php
                        $menu_link = $mn['menu_link'];
                        $menu_open = substr($menu_link, 1);
                        ?>
                        <li class="nav-item <?php if ($menu_open == $menu_active) {
                                                echo "active submenu";
                                            } ?>">
                            <a data-toggle="collapse" href="<?= $menu_link; ?>" class="collapsed" aria-expanded="false">
                                <i class="<?= $mn['menu_icon']; ?>"></i>
                                <p><?= $mn['menu_name']; ?></p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse <?php if ($menu_open == $menu_active) {
                                                        echo "show";
                                                    } ?>" id="<?= $menu_open; ?>">
                                <ul class="nav nav-collapse">
                                    <?php foreach ($submenu->result_array() as $sub) : ?>
                                        <li <?php if ($sub['menu_link'] == $submenu_active) {
                                                echo "class='active'";
                                            } ?>>
                                            <a href="<?= site_url($sub['menu_link']); ?>">
                                                <span class="sub-item"><?= $sub['menu_name']; ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>