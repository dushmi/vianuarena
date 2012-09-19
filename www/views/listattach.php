<?php
include('header.php');
require_once(IA_ROOT_DIR . "www/format/table.php");
require_once(IA_ROOT_DIR . "www/format/format.php");

?>

<script type="text/javascript">
    function rename_form(id) {
        if (document.getElementById("rename_"+id).style.display == "none") {
            document.getElementById("rename_"+id).style.display = "inline";
            document.getElementById("link_"+id).style.display = "none";
            document.getElementById("rename_link_"+id).textContent = "Anuleaza";
        }
        else {
            document.getElementById("rename_"+id).style.display = "none";
            document.getElementById("link_"+id).style.display = "inline";
            document.getElementById("rename_link_"+id).textContent = "Redenumeste";
        }

    }
    function attachments_toggle_selection(checked) {
        var check_boxes = getElementsByTagAndClassName('input', 'attach-checkbox');

        for (var index in check_boxes) {
            check_boxes[index].checked = checked;
        }
    }
</script>

<?php
function format_attach_id($row) {
    $id = $row['id'];
    return "#$id";
}

function format_attach_name($row) {
    global $page_name;

    $attachurl = '<span id="rename_'.$row['id'].'" style="display: none">';
    $attachurl .= '<form action="'.url_attachment_rename($page_name).'" method="post">';
    $attachurl .= '<input type="hidden" name="old_name" value="'.$row['name'].'"/>';
    $attachurl .= '<input type="text" name="new_name" value="'.$row['name'].'"/>';
    $attachurl .= '<input type="submit" value="OK" class="button"/>';
    $attachurl .= '</form></span>';
    $attachurl .= '<span id="link_'.$row['id'].'">';
    $attachurl .= format_link(url_attachment($page_name, $row['name']), $row['name']);
    $attachurl .= '</span>';
    return $attachurl;
}

function format_attach_size($row) {
    $size = sprintf("%.2f", $row['size'] / 1024);
    return "$size kb";

}

function format_attach_zip($row) {
    $id = html_escape($row["id"]);
    $name = html_escape($row["name"]);
    $attachurl = "<input type='checkbox' name='$id' value='$name' class='attach-checkbox'>";
    return $attachurl;
}

function format_ip($row) {
    if ($row['remote_ip_info'] && identity_can('attach-view-ip', $row)) {
        return html_escape($row['remote_ip_info']);
    } else {
        return 'N/A';
    }
}

function format_operations($row) {
    global $page_name;

    $delurl = format_post_link(url_attachment_delete($page_name, $row['name']),
                               "Sterge", array(), true,
                               array("onclick" => "return confirm('Aceasta actiune este ireversibila! Doresti sa continui?')"));

    $renurl = '<a href="#" id="rename_link_'.$row['id'].'" onclick="rename_form('.$row['id'].')">Redenumeste</a>';

    return '['.$delurl.'] ['.$renurl.']';
}

$column_infos = array(
    array (
        'html_title' => '<input type="checkbox" ' .
                'onclick="attachments_toggle_selection(this.checked)" />',
        'key' => 'zip',
        'rowform' => 'format_attach_zip'
    ),
    array(
        'title' => 'Numar',
        'key' => 'id',
        'rowform' => 'format_attach_id'
    ),
    array(
        'title' => 'Nume',
        'key' => 'name',
        'rowform' => 'format_attach_name'
    ),
    array(
        'title' => 'Utilizator',
        'key' => 'username',
        'rowform' => function($row) {
            return format_user_tiny($row['username'], $row['user_fullname']);
        },
    ),
    array(
        'title' => 'Marime',
        'key' => 'size',
        'rowform' => 'format_attach_size'
    ),
    array(
        'title' => 'Data',
        'key' => 'timestamp',
        'valform' => 'format_date',
    ),
    array(
        'title' => 'IP',
        'rowform' => 'format_ip',
    ),
    array(
        'title' => 'Operatii',
        'rowform' => 'format_operations',
    ),
);
?>
    <form method = 'post' action = ''>
    <input type = 'hidden' name = 'action' value = 'attach-bulk-action'>
    <h1>Atasamente pentru pagina <?= format_link(url_textblock($view['page_name']), $view['page_name']) ?></h1>
    <?php
        $options = array(
            'display_entries' => $view['display_entries'],
            'total_entries' => $view['total_entries'],
            'first_entry' => $view['first_entry'],
            'pager_style' => 'standard',
            'show_count' => true,
            'show_display_entries' => true,
            'css_class' => 'fill-screen',
        );

        echo format_table($view['attach_list'], $column_infos, $options);
    ?>

    <p><?= format_link(url_attachment_new($page_name), 'Ataseaza un alt fisier') ?></p>
    <?php
        if($view['total_entries']) {
    ?>
    <p><input type="submit" value="Descarca ZIP" class="button" name="download"/></p>
    <p><input type="submit" value="Sterge Atasamente" class="button" name="delete" onclick = "return confirm('Aceasta actiune este ireversibila! Doresti sa continui?');"/></p>
    <?php } ?>
    </form>
<?php include('footer.php'); ?>
