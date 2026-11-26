<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>favicon.png">
        <title>Pendaftaran ETA Host School - AMINEF Fulbright Indonesia</title>
        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Google Font: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?php echo base_url() ?>css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #0f3668;
        }

        /* Input field styling persis tangkapan layar */
        .eta-input {
            background-color: #ebf1f8;
            border: 1px solid #c9dcf1;
            color: #1e293b;
            transition: all 0.2s ease-in-out;
        }
        .eta-input:focus {
            background-color: #ffffff;
            border-color: #008cd3;
            box-shadow: 0 0 0 3px rgba(0, 140, 211, 0.22);
            outline: none;
        }

        /* Tombol utama biru khas AMINEF */
        .btn-eta-primary {
            background-color: #008cd3;
            transition: background-color 0.2s ease, transform 0.1s ease, box-shadow 0.2s ease;
        }
        .btn-eta-primary:hover {
            background-color: #0077b5;
            box-shadow: 0 4px 14px rgba(0, 140, 211, 0.35);
        }
        .btn-eta-primary:active {
            transform: scale(0.99);
        }

        /* Animasi pergantian state view yang halus */
        .view-card {
            animation: fadeInSlide 0.28s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeInSlide {
            from {
            opacity: 0;
            transform: translateY(8px);
            }
            to {
            opacity: 1;
            transform: translateY(0);
            }
        }
        </style>
    </head>
    <body class="min-h-screen text-slate-800 flex flex-col justify-between relative overflow-x-hidden selection:bg-sky-500 selection:text-white">

        <!-- <div class="absolute top-0 right-0 pointer-events-none z-0 overflow-hidden w-44 h-44 sm:w-72 sm:h-72 lg:w-80 lg:h-80">
            <img src="<?= base_url() ?>css/images/aminef-heading-vector.jpg" alt="AMINEF" class="w-full">
        </div> -->

        <header class="pt-8 sm:pt-12 px-4 flex flex-col items-center justify-center relative z-10">
            <div class="flex items-center gap-5 sm:gap-8 text-white select-none">
            
            <!-- AMINEF Logo Mark -->
            <div class="text-right">
                <img src="<?= base_url() ?>css/images/logo-aminef-2.png" width="130" alt="AMINEF">
            </div>

            <!-- <div class="h-10 sm:h-12 w-[1.5px] bg-white/30"></div> -->

            <!-- FULBRIGHT Indonesia Logo Mark -->
            <div class="flex items-center gap-2.5">
                <img src="<?= base_url() ?>css/images/logo-fulbright-2.png" width="200" alt="Fulbright Indonesia">
            </div>

            </div>
        </header>

        <main class="flex-grow flex items-center justify-center px-4 py-8 relative z-10">
            <div id="authCard" class="w-full max-w-[800px] bg-white rounded-xl shadow-2xl p-6 sm:p-9 min-h-[380px] flex flex-col justify-center transition-all duration-300">
                <?php echo $content; ?>
            </div>
        </main>

        <?php if (!empty($active_eta_app) && !empty($active_eta_app->guide_file)) { ?>
        <footer class="pb-8 pt-2 px-4 text-center text-xs text-white relative z-10 space-y-1.5">
            <div class="pt-0.5">
                Jika anda merasa kesulitan mendaftar
            </div>
            <div>
                <a
                    href="<?= base_url() ?><?= $active_eta_app->guide_file ?>" download
                    class="text-orange-500 hover:text-orange-400 font-bold underline inline-block transition-colors">
                    Unduh Instruksi Pendaftaran
                </a>
            </div>
        </footer>
        <?php } ?>

        <script>
            // Toggle Sembunyikan / Tampilkan Password
            function togglePasswordVisibility(inputId, iconId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                    `;
                } else {
                    input.type = 'password';
                    icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    `;
                }
            }
        </script>

        <!-- jQuery -->
        <script src="<?php echo base_url() ?>js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo base_url() ?>js/bootstrap.min.js"></script>

        <!-- jQuery UI -->
        <script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo base_url() ?>js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo base_url() ?>js/sb-admin-2.js"></script>
        
        <?php echo isset($script) ? $script : '' ?>

        <script>
        $( function() {
            $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd M yy",
            yearRange: "<?php echo date('Y') - 100 ?>:<?php echo date('Y') + 20 ?>"
            });
        } );
    
        $(document).on('change', '.dont_have_first_name', function() {
            let input = $(this).closest('.form-group').find('input[type="text"], input.form-control').first();

            if ($(this).is(':checked')) {
                input.val('FNU').prop('disabled', true);
            } else {
                input.val('').prop('disabled', false);
            }
        });

        $(document).ready(function() {
        $('.dont_have_first_name').trigger('change');
        });

        function openModal(id) {
            const modal = document.getElementById(id);

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            const modal = document.getElementById(id);

            modal.classList.add('hidden');
            modal.classList.remove('flex');

            document.body.style.overflow = '';
        }

        // Close modal with ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id$="Modal"].flex').forEach(modal => {
                    closeModal(modal.id);
                });
            }
        });
        </script>
    </body>
</html>