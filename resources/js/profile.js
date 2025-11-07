/**
 * Scripts para a página de perfil do usuário
 */

document.addEventListener('DOMContentLoaded', function() {
    // ============================================
    // Gerenciamento de abas
    // ============================================
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const tabName = button.getAttribute('data-tab');

            // Remove estilos ativos de todos os botões e conteúdos
            tabButtons.forEach(tab => {
                tab.classList.remove('active', 'border-b-amber-600', 'text-amber-700');
                tab.classList.add('text-gray-700', 'border-b-transparent');
            });
            tabContents.forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('active');
            });

            // Adiciona estilos ativos ao botão e conteúdo selecionados
            button.classList.add('active', 'border-b-amber-600', 'text-amber-700');
            button.classList.remove('text-gray-700', 'border-b-transparent');

            const targetContent = document.getElementById(`${tabName}-content`);
            if (targetContent) {
                targetContent.classList.remove('hidden');
                targetContent.classList.add('active');
            }
        });
    });

    // ============================================
    // Alternância de visibilidade de senha
    // ============================================
    const passwordToggles = document.querySelectorAll('.password-toggle');

    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            const input = toggle.parentElement.querySelector('input');
            const icon = toggle.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // ============================================
    // Sistema de alertas
    // ============================================
    function showAlert(message, type = 'info', duration = 5000) {
        const container = document.getElementById('alerts-container');
        if (!container) return;

        const alertDiv = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-50 border-green-200' :
                       type === 'error' ? 'bg-red-50 border-red-200' :
                       'bg-blue-50 border-blue-200';
        const textColor = type === 'success' ? 'text-green-700' :
                         type === 'error' ? 'text-red-700' :
                         'text-blue-700';
        const iconColor = type === 'success' ? 'text-green-600' :
                         type === 'error' ? 'text-red-600' :
                         'text-blue-600';

        alertDiv.className = `${bgColor} border rounded-lg p-4 shadow-md animate-fade-in flex items-start gap-3`;
        alertDiv.innerHTML = `
            <i class="fas ${getAlertIcon(type)} ${iconColor} text-lg flex-shrink-0 mt-0.5"></i>
            <div class="flex-1">
                <p class="${textColor} font-medium">${message}</p>
            </div>
            <button type="button" class="alert-close text-gray-400 hover:text-gray-600 transition-colors ml-auto flex-shrink-0">
                <i class="fas fa-times text-lg"></i>
            </button>
        `;

        container.appendChild(alertDiv);

        const closeBtn = alertDiv.querySelector('.alert-close');
        closeBtn.addEventListener('click', () => {
            alertDiv.classList.add('animate-fade-out');
            setTimeout(() => alertDiv.remove(), 300);
        });

        if (duration > 0) {
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.classList.add('animate-fade-out');
                    setTimeout(() => alertDiv.remove(), 300);
                }
            }, duration);
        }
    }

    // Helper para pegar o ícone correto para cada tipo de alerta
    function getAlertIcon(type) {
        switch(type) {
            case 'success':
                return 'fa-check-circle';
            case 'error':
                return 'fa-exclamation-circle';
            default:
                return 'fa-info-circle';
        }
    }

    // ============================================
    // Verificação de flash messages
    // ============================================
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'profile-updated') {
        showAlert('Perfil atualizado com sucesso!', 'success');
    }

    // ============================================
    // Validação de formulário
    // ============================================
    const form = document.querySelector('.profile-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');

            // Validação: se a nova senha foi preenchida, deve ter confirmação
            if (password.value || passwordConfirmation.value) {
                if (password.value !== passwordConfirmation.value) {
                    e.preventDefault();
                    showAlert('As senhas não correspondem. Por favor, verifique.', 'error', 5000);

                    // Muda para a aba de segurança
                    const securityTab = document.querySelector('[data-tab="security"]');
                    if (securityTab) {
                        securityTab.click();
                    }

                    // Foca no primeiro campo de senha
                    password.focus();
                    return false;
                }

                // Validação: senha atual é obrigatória se alterando senha
                const currentPassword = document.getElementById('current_password');
                if (!currentPassword.value) {
                    e.preventDefault();
                    showAlert('Por favor, informe sua senha atual para alterar a senha.', 'error', 5000);

                    const securityTab = document.querySelector('[data-tab="security"]');
                    if (securityTab) {
                        securityTab.click();
                    }

                    currentPassword.focus();
                    return false;
                }
            }
        });
    }
});

// Adicionar estilos de animação ao documento
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(1rem);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-1rem);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    .animate-fade-out {
        animation: fadeOut 0.3s ease-out;
    }
`;
document.head.appendChild(style);