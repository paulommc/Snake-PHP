<?php
session_start();
session_destroy();
header("Location: snake.php");