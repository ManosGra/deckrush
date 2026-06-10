<?php 
ob_start(); 

// ΟΡΙΣΜΟΣ SEO TAGS ΓΙΑ ΤΗΝ ΑΡΧΙΚΗ ΣΕΛΙΔΑ (Πριν το Header)
$page_title = "DeckRush | Αυθεντικές Κάρτες TCG & Συλλεκτικά είδη στην Ελλάδα";
$meta_description = "Το απόλυτο e-shop για συλλέκτες! Βρείτε σπάνιες κάρτες Pokémon, One Piece, Yu-Gi-Oh!, Magic: The Gathering, αξεσουάρ TCG και φιγούρες Funko Pop.";

include 'includes/header.php'; 

$is_main_page = true; 

include 'includes/navigation.php'; 
include 'includes/hero.php'; 
include 'categories.php';
include 'collectors_vault.php'; 
include 'top-sale.php';
include 'includes/footer.php'; 
?>
