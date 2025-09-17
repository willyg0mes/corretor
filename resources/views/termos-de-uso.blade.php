@extends('layouts.app')

@section('title', 'Termos de Uso - Alaor Corretor de Imóveis')

@section('content')
<section class="py-16 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Termos de Uso</h1>
            <p class="text-lg text-gray-600">Leia atentamente os termos e condições de uso da plataforma</p>
            <div class="mt-4 text-sm text-gray-500">
                Última atualização: {{ date('d/m/Y') }}
            </div>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
            <div class="prose prose-lg max-w-none text-gray-700">

                <h2 class="text-2xl font-bold text-gray-900 mb-6">1. Aceitação dos Termos</h2>
                <p class="mb-6">
                    Ao acessar e utilizar a plataforma Alaor Corretor de Imóveis, você concorda em cumprir e estar vinculado a estes Termos de Uso. Se você não concordar com estes termos, por favor, não utilize nossos serviços.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">2. Descrição do Serviço</h2>
                <p class="mb-6">
                    A plataforma Alaor Corretor de Imóveis oferece serviços de corretagem imobiliária online, incluindo:
                </p>
                <ul class="list-disc list-inside mb-6 ml-4">
                    <li>Anúncios de imóveis para venda e locação</li>
                    <li>Busca e filtragem de imóveis</li>
                    <li>Contato direto com corretores</li>
                    <li>Agendamento de visitas</li>
                    <li>Gerenciamento de imóveis (para corretores cadastrados)</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">3. Cadastro e Conta de Usuário</h2>
                <p class="mb-4">
                    Para utilizar algumas funcionalidades da plataforma, é necessário criar uma conta. Ao se cadastrar, você concorda em:
                </p>
                <ul class="list-disc list-inside mb-6 ml-4">
                    <li>Fornecer informações verdadeiras e atualizadas</li>
                    <li>Manter a confidencialidade de sua senha</li>
                    <li>Notificar imediatamente qualquer uso não autorizado de sua conta</li>
                    <li>Ser responsável por todas as atividades realizadas em sua conta</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">4. Uso Aceitável</h2>
                <p class="mb-4">
                    Você concorda em utilizar a plataforma apenas para fins legais e de acordo com estes termos. É proibido:
                </p>
                <ul class="list-disc list-inside mb-6 ml-4">
                    <li>Publicar conteúdo falso, enganoso ou prejudicial</li>
                    <li>Violar direitos de propriedade intelectual</li>
                    <li>Realizar atividades fraudulentas ou ilegais</li>
                    <li>Interferir no funcionamento da plataforma</li>
                    <li>Enviar spam ou mensagens não solicitadas</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">5. Propriedade Intelectual</h2>
                <p class="mb-6">
                    Todo o conteúdo da plataforma, incluindo textos, imagens, logotipos, software e design, é de propriedade da Alaor Corretor de Imóveis ou de seus licenciadores e está protegido por leis de direitos autorais e propriedade intelectual.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">6. Anúncios de Imóveis</h2>
                <p class="mb-4">
                    Os anúncios publicados na plataforma são de responsabilidade dos corretores anunciantes. A Alaor Corretor de Imóveis:
                </p>
                <ul class="list-disc list-inside mb-6 ml-4">
                    <li>Não garante a veracidade das informações dos anúncios</li>
                    <li>Não se responsabiliza por negociações entre usuários</li>
                    <li>Recomenda verificar todas as informações antes de qualquer transação</li>
                    <li>Se reserva o direito de remover anúncios que violem estes termos</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">7. Limitação de Responsabilidade</h2>
                <p class="mb-6">
                    A Alaor Corretor de Imóveis não se responsabiliza por danos diretos, indiretos, incidentais ou consequenciais decorrentes do uso ou incapacidade de uso da plataforma.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">8. Modificações dos Termos</h2>
                <p class="mb-6">
                    Reservamo-nos o direito de modificar estes termos a qualquer momento. As alterações entrarão em vigor imediatamente após sua publicação na plataforma. O uso continuado da plataforma após as modificações constitui aceitação dos novos termos.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">9. Lei Aplicável</h2>
                <p class="mb-6">
                    Estes termos são regidos pelas leis brasileiras. Qualquer disputa será submetida ao foro da Comarca de [Cidade], renunciando a qualquer outro, por mais privilegiado que seja.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">10. Contato</h2>
                <p class="mb-6">
                    Para dúvidas sobre estes termos ou sobre nossos serviços, entre em contato conosco através da <a href="https://wa.me/556294640321?text=Olá!%20Preciso%20de%20ajuda%20com%20a%20plataforma%20de%20imóveis." target="_blank" class="text-primary-600 hover:text-primary-700 font-medium">Central de Ajuda</a>.
                </p>

                <div class="mt-12 p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-center text-gray-600">
                        <strong>Ao utilizar nossa plataforma, você confirma que leu, compreendeu e concorda com estes Termos de Uso.</strong>
                    </p>
                </div>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-8">
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar ao Início
            </a>
        </div>
    </div>
</section>
@endsection
