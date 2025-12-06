<?php
function parseItems($itemsRaw) {
  $trimmed = trim($itemsRaw);
  if ($trimmed === "") {
    return array();
  }

  $parts = explode(",", $trimmed);
  $parts = array_map('trim', $parts);
  return $parts;
}

function getTotalIPs($items) {
  return count($items);
}
