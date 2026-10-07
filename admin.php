<?php
session_start();

require __DIR__ . '/config.php';

$error = '';
$success = '';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$isLoggedIn = !empty($_SESSION['admin_logged_in']);
$isAdminFolderRoute = strpos(str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? ''), '/admin/') !== false;
$basePath = $isAdminFolderRoute ? '../' : '';
$adminPath = $isAdminFolderRoute ? './' : 'admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (!hash_equals($_SESSION['csrf_token'], $csrfToken)) {
        $error = 'Invalid request. Please try again.';
    } elseif ($action === 'login') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (hash_equals($adminUsername, $username) && hash_equals($adminPassword, $password)) {
            $_SESSION['admin_logged_in'] = true;
            header("Location: {$adminPath}");
            exit;
        }

        $error = 'Incorrect username or password.';
    } elseif ($action === 'logout') {
        session_destroy();
        header("Location: {$adminPath}");
        exit;
    } elseif ($action === 'delete' && $isLoggedIn) {
        $id = (int) ($_POST['id'] ?? 0);

        if ($id > 0) {
            $stmt = $pdo->prepare('DELETE FROM contact_messages WHERE id = :id');
            $stmt->execute([':id' => $id]);
            $success = 'Message deleted.';
        }
    }
}

$messages = [];

if (!empty($_SESSION['admin_logged_in'])) {
    $stmt = $pdo->query('SELECT * FROM contact_messages ORDER BY created_at DESC, id DESC');
    $messages = $stmt->fetchAll();
}

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CANCARE CONNECT Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Poppins:wght@700;800&display=swap"
      rel="stylesheet"
    />
    <style>
      :root {
        --primary: #0057ff;
        --primary-dark: #0037a5;
        --accent: #00c8ff;
        --bg: #f7f9fc;
        --ink: #111827;
        --muted: #5b6780;
        --line: #dbe7ff;
        --white: #ffffff;
        --shadow: 0 28px 80px rgba(0, 55, 165, 0.13);
      }

      * { box-sizing: border-box; }

      body {
        margin: 0;
        min-height: 100vh;
        color: var(--ink);
        background:
          radial-gradient(circle at 15% 0%, rgba(0, 200, 255, 0.16), transparent 28rem),
          radial-gradient(circle at 90% 10%, rgba(0, 87, 255, 0.14), transparent 26rem),
          var(--bg);
        font-family: Inter, Arial, sans-serif;
      }

      a { color: inherit; }

      .admin-shell {
        width: min(1180px, calc(100% - 40px));
        margin: 0 auto;
        padding: 34px 0 70px;
      }

      .topbar,
      .panel,
      .login-card {
        border: 1px solid rgba(0, 87, 255, 0.12);
        background: rgba(255, 255, 255, 0.82);
        box-shadow: var(--shadow);
        backdrop-filter: blur(18px);
      }

      .topbar {
        min-height: 82px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        border-radius: 24px;
      }

      .brand {
        display: flex;
        align-items: center;
        gap: 14px;
      }

      .brand img {
        width: 54px;
        height: 54px;
        object-fit: contain;
      }

      .brand strong,
      h1,
      h2 {
        font-family: Poppins, Arial, sans-serif;
      }

      .brand strong,
      .brand small {
        display: block;
        line-height: 1;
      }

      .brand strong {
        color: var(--primary-dark);
        font-size: 1.2rem;
      }

      .brand small {
        margin-top: 5px;
        color: var(--primary);
        font-weight: 800;
      }

      .actions {
        display: flex;
        align-items: center;
        gap: 12px;
      }

      .btn,
      button {
        min-height: 44px;
        border: 0;
        border-radius: 14px;
        padding: 12px 18px;
        color: var(--white);
        background: linear-gradient(135deg, var(--primary), var(--accent));
        box-shadow: 0 18px 42px rgba(0, 87, 255, 0.24);
        font: inherit;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
      }

      .btn-light {
        color: var(--primary);
        background: var(--white);
        border: 1px solid var(--line);
        box-shadow: none;
      }

      .btn-danger {
        background: linear-gradient(135deg, #dc2626, #fb7185);
        box-shadow: none;
      }

      .hero {
        margin: 44px 0 28px;
      }

      h1 {
        margin: 0;
        font-size: clamp(2rem, 5vw, 4rem);
        line-height: 1.05;
      }

      .hero p {
        max-width: 700px;
        margin: 14px 0 0;
        color: var(--muted);
        font-size: 1.05rem;
      }

      .panel,
      .login-card {
        border-radius: 26px;
        padding: 28px;
      }

      .login-card {
        width: min(480px, 100%);
        margin: 58px auto 0;
      }

      .login-card h1 {
        font-size: 2rem;
      }

      label {
        display: grid;
        gap: 8px;
        margin-top: 18px;
        color: var(--ink);
        font-weight: 800;
      }

      input {
        width: 100%;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 14px 16px;
        color: var(--ink);
        background: #f8fbff;
        font: inherit;
      }

      .notice {
        margin: 18px 0 0;
        padding: 13px 15px;
        border-radius: 14px;
        font-weight: 800;
      }

      .notice.error {
        color: #991b1b;
        background: #fee2e2;
      }

      .notice.success {
        color: #065f46;
        background: #dcfce7;
      }

      .table-wrap {
        overflow-x: auto;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        min-width: 960px;
      }

      th,
      td {
        padding: 16px 14px;
        text-align: left;
        vertical-align: top;
        border-bottom: 1px solid var(--line);
      }

      th {
        color: var(--primary-dark);
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
      }

      td {
        color: var(--muted);
      }

      td strong {
        color: var(--ink);
      }

      .message-cell {
        max-width: 320px;
        white-space: pre-wrap;
      }

      .empty {
        padding: 42px;
        text-align: center;
        color: var(--muted);
      }

      @media (max-width: 720px) {
        .topbar,
        .actions {
          align-items: flex-start;
          flex-direction: column;
        }

        .actions,
        .actions .btn,
        .actions form,
        .actions button {
          width: 100%;
        }
      }
    </style>
  </head>
  <body>
    <main class="admin-shell">
      <header class="topbar">
        <a class="brand" href="<?= e($basePath) ?>index.html">
          <img src="<?= e($basePath) ?>assets/cancare-connect-logo.png" alt="" />
          <span><strong>CANCARE</strong><small>CONNECT ADMIN</small></span>
        </a>
        <div class="actions">
          <a class="btn btn-light" href="<?= e($basePath) ?>index.html">View Website</a>
          <?php if (!empty($_SESSION['admin_logged_in'])): ?>
            <form method="post">
              <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>" />
              <input type="hidden" name="action" value="logout" />
              <button type="submit">Log Out</button>
            </form>
          <?php endif; ?>
        </div>
      </header>

      <?php if (empty($_SESSION['admin_logged_in'])): ?>
        <section class="login-card">
          <h1>Admin Login</h1>
          <p>Sign in to view contact form submissions.</p>
          <?php if ($error !== ''): ?><div class="notice error"><?= e($error) ?></div><?php endif; ?>
          <form method="post">
            <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>" />
            <input type="hidden" name="action" value="login" />
            <label>Username<input type="text" name="username" required /></label>
            <label>Password<input type="password" name="password" required /></label>
            <label><button type="submit">Log In</button></label>
          </form>
        </section>
      <?php else: ?>
        <section class="hero">
          <h1>Contact Messages</h1>
          <p>Review inquiries submitted through the CANCARE CONNECT website contact form.</p>
          <?php if ($error !== ''): ?><div class="notice error"><?= e($error) ?></div><?php endif; ?>
          <?php if ($success !== ''): ?><div class="notice success"><?= e($success) ?></div><?php endif; ?>
        </section>

        <section class="panel">
          <?php if (count($messages) === 0): ?>
            <div class="empty">No contact messages yet.</div>
          <?php else: ?>
            <div class="table-wrap">
              <table>
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Phone</th>
                    <th>Message</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($messages as $message): ?>
                    <tr>
                      <td><?= e(date('M d, Y h:i A', strtotime($message['created_at']))) ?></td>
                      <td><strong><?= e($message['name']) ?></strong></td>
                      <td><a href="mailto:<?= e($message['email']) ?>"><?= e($message['email']) ?></a></td>
                      <td><?= e($message['company'] ?? '') ?></td>
                      <td><?= e($message['phone'] ?? '') ?></td>
                      <td class="message-cell"><?= e($message['message'] ?? '') ?></td>
                      <td>
                        <form method="post" onsubmit="return confirm('Delete this message?');">
                          <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>" />
                          <input type="hidden" name="action" value="delete" />
                          <input type="hidden" name="id" value="<?= e($message['id']) ?>" />
                          <button class="btn-danger" type="submit">Delete</button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        </section>
      <?php endif; ?>
    </main>
  </body>
</html>
