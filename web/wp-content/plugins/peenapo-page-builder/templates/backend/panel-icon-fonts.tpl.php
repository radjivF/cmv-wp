<?php
function get_list_of_icons( $font ) {
    
    //if( false === ( $icons = get_transient( "bwpb_font_icons_{$font}" ) ) ) {
        
        switch( $font ) {
            case 'font-awesome':
                $path = 'font-awesome/font-awesome.min.css';
                $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s*{\s*content/';
                break;
            case 'lineicons':
                $path = 'bwpb-lineicons/lineicons.css';
                $pattern = '/\.(bwpb-lineicon-(.*)):before\s*{\s*content/';
                break;
            case '7s':
                $path = 'bwpb-7-stroke/pe-icon-7-stroke.css';
                $pattern = '/\.(bwpb-7s-(.*)):before\s*{\s*content/';
                break;
            default: return array();
        }
        
        $subject = file_get_contents(PB_ROOT . 'assets' . PB_DS . 'fonts' . PB_DS . $path);
        
        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
        
        $icons = array();

        foreach($matches as $match) {
            $icons[] = $match[1];
        }
        //set_transient( "bwpb_font_icons_{$font}", $icons, 60 * 60 * 24 );
    //}
    
    return $icons;
}
?>

<script type="text/html" id="bwpb_font-font-awesome"><?php foreach( get_list_of_icons('font-awesome') as $icon ) : ?>
<?php echo "<li data-value='{$icon}' data-class='fa'><i class='fa {$icon}'></i></li>"; ?>
<?php endforeach; ?></script>

<script type="text/html" id="bwpb_font-openiconic"><?php foreach( get_list_of_icons('openiconic') as $icon ) : ?>
<?php echo "<li data-value='{$icon}'><i class='{$icon}'></i></li>"; ?>
<?php endforeach; ?></script>

<script type="text/html" id="bwpb_font-entypo"><?php foreach( get_list_of_icons('entypo') as $icon ) : ?>
<?php echo "<li data-value='{$icon}'><i class='{$icon}'></i></li>"; ?>
<?php endforeach; ?></script>

<script type="text/html" id="bwpb_font-lineicons"><?php foreach( get_list_of_icons('lineicons') as $icon ) : ?>
<?php echo "<li data-value='{$icon}'><i class='{$icon}'></i></li>"; ?>
<?php endforeach; ?></script>

<script type="text/html" id="bwpb_font-7s"><?php foreach( get_list_of_icons('7s') as $icon ) : ?>
<?php echo "<li data-value='{$icon}'><i class='{$icon}'></i></li>"; ?>
<?php endforeach; ?></script>


