@extends('layouts.app')

@section('title', 'Política de Privacidade - Alaor Corretor de Imóveis')

@section('content')
<section class="py-16 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Política de Privacidade</h1>
            <p class="text-lg text-gray-600">Como protegemos e utilizamos suas informações pessoais</p>
            <div class="mt-4 text-sm text-gray-500">
                Última atualização: {{ date('d/m/Y') }}
            </div>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
            <div class="prose prose-lg max-w-none text-gray-700">

                <h2 class="text-2xl font-bold text-gray-900 mb-6">1. Introdução</h2>
                <p class="mb-6">
                    A Alaor Corretor de Imóveis ("nós", "nosso" ou "empresa") está comprometida em proteger sua privacidade. Esta Política de Privacidade explica como coletamos, usamos, armazenamos e protegemos suas informações pessoais quando você utiliza nossa plataforma online.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">2. Informações que Coletamos</h2>
                <p class="mb-4">
                    Podemos coletar os seguintes tipos de informações:
                </p>

                <h3 class="text-xl font-semibold text-gray-800 mb-4">2.1 Informações Fornecidas por Você</h3>
                <ul class="list-disc list-inside mb-6 ml-4">
                    <li>Nome completo e informações de contato (e-mail, telefone)</li>
                    <li>Informações de perfil (profissão, preferências)</li>
                    <li>Conteúdo que você publica (anúncios, comentários, mensagens)</li>
                    <li>Informações sobre imóveis (endereços, características, preços)</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-4">2.2 Informações Coletadas Automaticamente</h3>
                <ul class="list-disc list-inside mb-6 ml-4">
                    <li>Endereço IP e localização geográfica aproximada</li>
                    <li>Tipo de dispositivo e navegador utilizado</li>
                    <li>Páginas visitadas e tempo de permanência</li>
                    <li>Cookies e tecnologias similares</li>
                    <li>Dados de uso da plataforma</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">3. Como Utilizamos suas Informações</h2>
                <p class="mb-4">
                    Utilizamos suas informações pessoais para:
                </p>
                <ul class="list-disc list-inside mb-6 ml-4">
                    <li>Fornecer e manter nossos serviços de corretagem imobiliária</li>
                    <li>Processar cadastros e gerenciar contas de usuário</li>
                    <li>Facilitar a comunicação entre compradores, vendedores e corretores</li>
                    <li>Personalizar sua experiência na plataforma</li>
                    <li>Enviar notificações importantes sobre seus anúncios ou negociações</li>
                    <li>Melhorar nossos serviços através de análises de uso</li>
                    <li>Cumprir obrigações legais e regulatórias</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">4. Compartilhamento de Informações</h2>
                <p class="mb-4">
                    Podemos compartilhar suas informações nas seguintes situações:
                </p>

                <h3 class="text-xl font-semibold text-gray-800 mb-4">4.1 Com outros Usuários</h3>
                <p class="mb-4">
                    Quando você entra em contato com outros usuários através da plataforma (corretores, compradores, vendedores), certas informações são compartilhadas para facilitar a comunicação e negociações imobiliárias.
                </p>

                <h3 class="text-xl font-semibold text-gray-800 mb-4">4.2 Prestadores de Serviços</h3>
                <p class="mb-4">
                    Podemos compartilhar informações com prestadores de serviços terceirizados que nos ajudam a operar a plataforma, desde que estes estejam sujeitos a obrigações de confidencialidade.
                </p>

                <h3 class="text-xl font-semibold text-gray-800 mb-4">4.3 Obrigações Legais</h3>
                <p class="mb-6">
                    Podemos divulgar informações quando exigido por lei, ordem judicial ou para proteger direitos, propriedade ou segurança de usuários e terceiros.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">5. Cookies e Tecnologias Similares</h2>
                <p class="mb-4">
                    Utilizamos cookies e tecnologias similares para:
                </p>
                <ul class="list-disc list-inside mb-6 ml-4">
                    <li>Lembrar suas preferências e configurações</li>
                    <li>Fornecer funcionalidades essenciais da plataforma</li>
                    <li>Analisar o uso e melhorar nossos serviços</li>
                    <li>Personalizar conteúdo e anúncios (se aplicável)</li>
                </ul>
                <p class="mb-6">
                    Você pode controlar o uso de cookies através das configurações do seu navegador, embora isso possa afetar algumas funcionalidades da plataforma.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">6. Segurança das Informações</h2>
                <p class="mb-6">
                    Implementamos medidas de segurança técnicas, administrativas e físicas apropriadas para proteger suas informações pessoais contra acesso não autorizado, alteração, divulgação ou destruição. No entanto, nenhum método de transmissão pela internet é 100% seguro.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">7. Retenção de Dados</h2>
                <p class="mb-6">
                    Mantemos suas informações pessoais apenas pelo tempo necessário para cumprir as finalidades descritas nesta política, a menos que um período de retenção mais longo seja exigido ou permitido por lei.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">8. Seus Direitos</h2>
                <p class="mb-4">
                    Você tem direito a:
                </p>
                <ul class="list-disc list-inside mb-6 ml-4">
                    <li>Acessar suas informações pessoais que mantemos</li>
                    <li>Corrigir dados incompletos, inexatos ou desatualizados</li>
                    <li>Solicitar a exclusão de seus dados pessoais</li>
                    <li>Solicitar a portabilidade de seus dados</li>
                    <li>Opor-se ao processamento de seus dados em certas circunstâncias</li>
                    <li>Retirar o consentimento quando aplicável</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">9. Menores de Idade</h2>
                <p class="mb-6">
                    Nossa plataforma não é destinada a menores de 18 anos. Não coletamos intencionalmente informações pessoais de menores de idade. Se tomarmos conhecimento de que coletamos informações de uma criança, tomaremos medidas para excluir essas informações prontamente.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">10. Alterações nesta Política</h2>
                <p class="mb-6">
                    Podemos atualizar esta Política de Privacidade periodicamente. Quando fizermos alterações significativas, notificaremos você através de um aviso destacado em nossa plataforma ou por outros meios apropriados.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">11. Lei Aplicável</h2>
                <p class="mb-6">
                    Esta política é regida pelas leis brasileiras, incluindo a Lei Geral de Proteção de Dados (LGPD - Lei nº 13.709/2018).
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">12. Contato</h2>
                <p class="mb-4">
                    Para questões sobre esta Política de Privacidade ou sobre como tratamos seus dados, entre em contato:
                </p>
                <ul class="list-disc list-inside mb-6 ml-4">
                    <li><strong>WhatsApp:</strong> <a href="https://wa.me/556294640321?text=Olá!%20Preciso%20de%20ajuda%20com%20a%20plataforma%20de%20imóveis." target="_blank" class="text-primary-600 hover:text-primary-700 font-medium">(62) 9464-0321</a></li>
                    <li><strong>Central de Ajuda:</strong> Use o link no rodapé do site</li>
                </ul>

                <div class="mt-12 p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-center text-gray-600">
                        <strong>Sua privacidade é importante para nós. Ao utilizar nossa plataforma, você concorda com a coleta e uso de informações conforme descrito nesta Política de Privacidade.</strong>
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
