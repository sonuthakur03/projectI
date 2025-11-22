<?php

$projectName = 'WanderLux - Discover Your Next Dream Destination';
$tagline = 'Building thoughtful, reliable web experiences';
$mission = 'To design and deliver clean, accessible web applications that solve real user problems and scale with teams.';

$team = [
    [
        'name' => 'Sonu Thakur',
        'role' => 'Product Lead',
        'bio' => 'Shapes product direction and ensures we solve the right problems.',
        'email' => 'rsonuth789@gmail.com'
    ],
    [
        'name' => 'Ripesh Shrestha',
        'role' => 'Designer',
        'bio' => 'Designs intuitive interfaces and consistent visual systems.',
        'email' => 'ripesh.stha12569@gmail.com'
    ]
];

// Helper: make initials for placeholder avatars
function initials($name) {
    $parts = preg_split('/\s+/', trim($name));
    $chars = '';
    foreach ($parts as $p) $chars .= mb_substr($p, 0, 1);
    return strtoupper(mb_substr($chars, 0, 2));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Wanderlux | About Us</title>
<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    line-height: 1.45;
}
.container {
    max-width: 1000px;
    margin: 80px auto;
    margin-bottom: 48px;
    padding: 24px;
    border-radius: 12px;
    background: rgba(255,255,255,0.05);
    border: 5px solid rgba(0, 0, 0, 0.1);

}
header.main {
    display: flex;
    gap: 24px;
    align-items: center;
}
.hero .intro {
    flex: 1;
}

h1 { 
  margin: 0 0 8px; 
  font-size: 28px; 
}
p.lead { 
  margin: 0; 
  color: #000000ff; 
}
.panel {
    background: rgba(255,255,255,0.03);
    padding: 18px;
    border-radius: 12px;
    margin-top: 18px;
    border: 3px solid rgba(0, 0, 0, 0.56);
  }
  .grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
    margin-top: 18px;
    width: 85%;
    justify-content: center;
    align-content: center;
  }
  .team {
    display: flex;
    flex-direction: column;
    gap: 12px;
    width: 100%;
  }
  .member {
    border: 3px solid rgba(0, 0, 0, 0.56);
    display: flex;
    gap: 12px;
    align-items: center;
    background: rgba(255,255,255,0.02);
    padding: 12px;
    border-radius: 10px;
    width: 100%;
}
.avatar {
    width: 56px;
    height: 56px;
    border-radius: 10px;
    background: linear-gradient(135deg, #06b6d4, #0ea5a4);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}
.meta {
    font-size: 14px;
}
.meta .role {
    color: #94a3b8;
    font-size: 13px;
    margin-top: 4px;
}
.meta a {
    color: #06b6d4;
    font-size: 13px;
    text-decoration: none;
}
@media (max-width: 880px) {
    .grid { grid-template-columns: 1fr; }
    header.hero { flex-direction: column; align-items: flex-start; }
    .logo { width: 72px; height: 72px; }
}
</style>
</head>
<body>
<div class="container">
    <header class="main">
        <div class="intro">
            <h1><?= htmlspecialchars($projectName) ?></h1>
            <p class="lead"><?= htmlspecialchars($tagline) ?></p>
            <div class="panel">
                <strong>Our Mission</strong>
                <p><?= htmlspecialchars($mission) ?></p>
            </div>
        </div>
    </header>

    <div class="grid">
        <aside>
            <h2 style="font-size: 18px; margin: 18px 0 10px">Team</h2>
            <div class="team">
                <?php foreach($team as $m): ?>
                <div class="member">
                    <div class="avatar"><?= initials($m['name']) ?></div>
                    <div class="meta">
                        <div style="font-weight:700"><?= htmlspecialchars($m['name']) ?></div>
                        <div class="role"><?= htmlspecialchars($m['role']) ?></div>
                        <div><?= htmlspecialchars($m['bio']) ?></div>
                        <div><a href="mailto:<?= htmlspecialchars($m['email']) ?>"><?= htmlspecialchars($m['email']) ?></a></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </aside>
    </div>

</div>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
