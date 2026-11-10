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

function e(mixed $value): string
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
    <link rel="icon" type="image/png" href="<?= e($basePath) ?>assets/cancare-connect-logo.png" />
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

      .brand { text-decoration: none; }

      .admin-shell {
        width: min(1440px, calc(100% - 24px));
        margin: 0 auto;
        padding: 12px 0 70px;
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
        min-height: 76px;
        padding: 13px 20px;
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
        width: 50px;
        height: 50px;
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

      .confirm-dialog {
        width: min(420px, calc(100% - 32px));
        border: 1px solid var(--line);
        border-radius: 20px;
        padding: 26px;
        color: var(--ink);
        background: var(--white);
        box-shadow: var(--shadow);
      }

      .confirm-dialog::backdrop {
        background: rgba(17, 24, 39, 0.48);
        backdrop-filter: blur(3px);
      }

      .confirm-dialog h2 {
        margin: 0;
        font-size: 1.35rem;
      }

      .confirm-dialog p {
        margin: 10px 0 22px;
        color: var(--muted);
      }

      .confirm-dialog-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
      }

      .confirm-dialog-actions button {
        min-height: 42px;
      }

      .hero {
        margin: 28px 0 22px;
        padding-top: 6px;
      }

      .hero-kicker {
        display: inline-flex;
        margin-bottom: 10px;
        padding: 7px 11px;
        border-radius: 999px;
        color: var(--primary);
        background: #eaf2ff;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
      }

      h1 {
        margin: 0;
        font-size: clamp(2rem, 4vw, 3.25rem);
        line-height: 1.05;
      }

      .hero p {
        max-width: 700px;
        margin: 0;
        color: var(--muted);
        font-size: 1.05rem;
      }

      .hero h1 {
        font-size: 2rem;
        margin-bottom: 6px;
      }

      .panel,
      .login-card {
        border-radius: 26px;
        padding: 14px;
      }

      .login-card {
        width: min(460px, 100%);
        margin: 120px auto 0;
        position: relative;
        overflow: hidden;
        padding: 32px 30px 30px;
        background:
          radial-gradient(circle at 100% 0%, rgba(0, 194, 255, 0.14), transparent 35%),
          rgba(255, 255, 255, 0.9);
        text-align: center;
      }

      .login-card::before {
        content: "SECURE ADMIN AREA";
        display: inline-flex;
        margin-bottom: 16px;
        padding: 7px 11px;
        border-radius: 999px;
        color: var(--primary);
        background: #eaf2ff;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.1em;
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
        text-align: left;
      }

      input {
        width: 100%;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 14px 16px;
        color: var(--ink);
        background: #f8fbff;
        font: inherit;
        font-weight: 400;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
      }

      input:focus {
        outline: none;
        border-color: var(--primary);
        background: var(--white);
        box-shadow: 0 0 0 4px rgba(0, 87, 255, 0.1);
      }

      .login-card button[type="submit"] {
        width: 100%;
        margin-top: 4px;
        min-height: 54px;
        font-size: 1rem;
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
        min-width: 960px;
        border-collapse: collapse;
      }

      th,
      td {
        padding: 10px 12px;
        text-align: left;
        vertical-align: middle;
        border-bottom: 1px solid var(--line);
      }

      tbody tr {
        transition: background 0.2s ease;
      }

      tbody tr:hover {
        background: rgba(234, 242, 255, 0.55);
      }

      td a {
        color: #243b64;
        font-weight: 700;
        overflow-wrap: anywhere;
        text-decoration: none;
      }

      td a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
      }

      th {
        color: var(--primary-dark);
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
      }

      td {
        color: #243b64;
      }

      td strong {
        color: #162a4a;
      }

      .message-cell {
        max-width: 240px;
        white-space: pre-wrap;
      }

      .message-actions {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 8px;
      }

      .message-actions .btn-danger {
        padding: 7px 10px;
        font-size: 0.92rem;
      }

      th:last-child {
        text-align: left;
      }

      .btn-view {
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 7px 10px;
        color: var(--primary-dark);
        background: #eef5ff;
        box-shadow: none;
        font: inherit;
        font-size: 0.92rem;
        font-weight: 800;
        cursor: pointer;
      }

      .message-dialog,
      .confirm-dialog {
        width: min(560px, calc(100% - 32px));
        border: 1px solid var(--line);
        border-radius: 22px;
        padding: 28px;
        color: var(--ink);
        background: var(--white);
        box-shadow: var(--shadow);
      }

      .message-dialog::backdrop,
      .confirm-dialog::backdrop {
        background: rgba(7, 23, 53, 0.42);
        backdrop-filter: blur(4px);
      }

      .message-dialog h2 {
        margin: 0 0 16px;
        font-family: Poppins, Arial, sans-serif;
      }

      .message-dialog-content {
        max-height: 320px;
        overflow: auto;
        padding: 16px;
        border-radius: 14px;
        white-space: pre-wrap;
        color: var(--muted);
        background: #f7faff;
      }

      .dialog-close {
        margin-top: 18px;
        width: 100%;
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
          <span><strong>CANCARE</strong><small>CONNECT</small></span>
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
          <span class="hero-kicker">Inbox Overview</span>
          <h1>Contact Messages</h1>
          <p>Messages from your website contact form.</p>
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
                      <td class="message-cell"><?= e($message['message'] ?? '') ?></td>
                      <td>
                        <div class="message-actions">
                          <button class="btn-view" type="button" data-view-message="<?= e($message['message'] ?? '') ?>">View</button>
                        <form method="post" data-delete-form>
                          <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>" />
                          <input type="hidden" name="action" value="delete" />
                          <input type="hidden" name="id" value="<?= e($message['id']) ?>" />
                          <button class="btn-danger" type="submit">Delete</button>
                        </form>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <dialog class="confirm-dialog" id="delete-confirmation" aria-labelledby="delete-confirmation-title">
              <h2 id="delete-confirmation-title">Delete this message?</h2>
              <p>Are you sure you want to delete this message? This action cannot be undone.</p>
              <div class="confirm-dialog-actions">
                <button class="btn-light" type="button" data-cancel-delete>No, keep it</button>
                <button class="btn-danger" type="button" data-confirm-delete>Yes, delete</button>
              </div>
            </dialog>
            <dialog class="message-dialog" id="message-viewer" aria-labelledby="message-viewer-title">
              <h2 id="message-viewer-title">Client Message</h2>
              <div class="message-dialog-content" id="message-viewer-content"></div>
              <button class="btn dialog-close" type="button" data-close-message>Close</button>
            </dialog>
          <?php endif; ?>
        </section>
      <?php endif; ?>
    </main>
    <script>
      const deleteDialog = document.getElementById('delete-confirmation');
      let pendingDeleteForm;

      if (deleteDialog) {
        document.querySelectorAll('[data-delete-form]').forEach((form) => {
          form.addEventListener('submit', (event) => {
            event.preventDefault();
            pendingDeleteForm = form;
            deleteDialog.showModal();
          });
        });

        deleteDialog.querySelector('[data-cancel-delete]').addEventListener('click', () => {
          pendingDeleteForm = undefined;
          deleteDialog.close();
        });

        deleteDialog.querySelector('[data-confirm-delete]').addEventListener('click', () => {
          if (pendingDeleteForm) {
            pendingDeleteForm.submit();
          }
        });
      }

      const messageViewer = document.getElementById('message-viewer');
      const messageViewerContent = document.getElementById('message-viewer-content');

      if (messageViewer) {
        document.querySelectorAll('[data-view-message]').forEach((button) => {
          button.addEventListener('click', () => {
            messageViewerContent.textContent = button.dataset.viewMessage || 'No message provided.';
            messageViewer.showModal();
          });
        });

        messageViewer.querySelector('[data-close-message]').addEventListener('click', () => {
          messageViewer.close();
        });
      }
    </script>
  </body>
</html>
