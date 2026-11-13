# Rem Soft Projeto Padrão

Base reutilizável para aplicações da Rem Soft, com autenticação, administração de usuários e perfis de acesso, operações de suporte e componentes de interface compartilhados. A lógica de negócio usa Laravel, Livewire e Actions PHP com contratos explícitos e Jobs nativos do Laravel. Esta base não representa um produto de negócio completo.

As fontes de verdade para dependências e comandos são [composer.json](composer.json), [composer.lock](composer.lock), [package.json](package.json), [package-lock.json](package-lock.json) e as configurações versionadas. Os recursos descritos abaixo correspondem à implementação disponível; pacotes instalados não representam funcionalidades de negócio prontas.

## Stack e requisitos

| Camada                 | Versões resolvidas nos lockfiles                                            |
| ---------------------- | --------------------------------------------------------------------------- |
| Aplicação              | Laravel 13.40.0, Livewire 4.4.8, Sanctum 4.3.3                              |
| Interface              | Tailwind CSS 4.3.3, daisyUI 5.7.28, Alpine.js 3.17.2                        |
| Build e automação      | Vite 8.3.6, Laravel Vite Plugin 3.2.0, Playwright 1.63.0, Puppeteer 25.16.0 |
| Qualidade PHP          | Pest 5.3.5, PHPUnit 13.4.5, Pint 1.32.1, Larastan 3.14.0                    |
| Formatação frontend    | Prettier 3.9.6, plugin Blade 3.3.3, plugin Tailwind 0.8.1                   |
| Ferramentas de agentes | Laravel Boost 2.10.4                                                        |

- **Laravel Herd** para PHP e servidor local. Use PHP 8.4 atualizado, com mínimo **8.4.1** para todas as dependências de desenvolvimento: o manifesto exige `^8.4`, mas o PHPUnit travado exige `>=8.4.1`. As verificações locais foram executadas com PHP 8.4.27.
- **Node.js >=22.12.0** para o conjunto completo. Vite aceita `^20.19.0 || >=22.12.0`, mas Puppeteer exige `>=22.12.0`; Node 20 não atende toda a instalação.
- Composer 2 compatível com `composer-runtime-api ^2.2.2`, exigido pelas dependências travadas, e npm com suporte ao `package-lock.json` versão 3. Os manifestos não fixam uma versão mínima própria de Composer/npm.
- **PostgreSQL** como banco da aplicação e dos testes com persistência, com `pdo_pgsql` no PHP do Herd. O provisionamento versionado usa PostgreSQL 16.15 com UTF-8 e ICU; disponibilize `citext` e `unaccent` em cada banco. As validações locais registradas foram executadas no PostgreSQL 18.6; isso não comprova a execução no runner PostgreSQL 16 nem altera a referência de provisionamento.
- Crie bancos e credenciais separados para aplicação e testes. O papel de migrations precisa provisionar as extensões ou recebê-las instaladas; testes paralelos precisam de permissão para criar seus bancos exclusivos. O Compose permanece opcional e usa o volume PostgreSQL próprio, sem converter volumes antigos.
- Extensões PHP exigidas pelo lock e pelo driver de imagens configurado. TIA precisa de PCOV ou Xdebug com cobertura habilitada para gravar seu mapa, mesmo sem exigir percentual de cobertura. Confira a plataforma com `composer check-platform-reqs`.

Use os lockfiles para reproduzir dependências; não execute atualizações de pacotes como parte do setup.

## Instalação com Laravel Herd

Depois de clonar o repositório, abra um terminal na raiz e confirme `php --version`, `composer --version` e `node --version`. O PHP no PATH deve ser o do Herd.

### 1. Dependências e ambiente

```bash
composer install
npm ci --ignore-scripts
```

O script `pre-install-cmd` copia `.env.example` para `.env` e `.env.testing.example` para `.env.testing` quando esses arquivos ainda não existem. Arquivos existentes são preservados. Se uma cópia falhar, a instalação interrompe com uma mensagem de correção. Revise os arquivos antes de acessar serviços: os defaults de PostgreSQL apontam para o host local, mas Redis, SMTP e storage ainda podem conter exemplos de infraestrutura em contêiner.

| Configuração                                | Ajuste para desenvolvimento local                                                                                   |
| ------------------------------------------- | ------------------------------------------------------------------------------------------------------------------- |
| `APP_NAME`, `APP_ENV`, `APP_URL`            | Nome do projeto, `local` e URL efetiva do site cadastrado no Herd.                                                  |
| `SAIL_ENABLED`                              | `false`; Sail e `compose.yaml` permanecem no repositório, mas não fazem parte deste setup.                          |
| `DB_CONNECTION`, `DB_HOST`, `DB_PORT`       | `pgsql`, host real do PostgreSQL local (normalmente `127.0.0.1`) e porta do serviço (normalmente `5432`).           |
| `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | Banco previamente criado e credenciais locais; substitua os valores de exemplo.                                     |
| `QUEUE_CONNECTION`, `QUEUE_PREFIX`          | `database`; o prefixo é opcional em todos os ambientes.                                                             |
| `SESSION_DRIVER`, `CACHE_STORE`             | `database`; as tabelas são criadas pelas migrations.                                                                |
| `MAIL_MAILER`                               | `log` para registrar mensagens sem enviar e-mails reais. Configure SMTP ou Brevo explicitamente para entrega.       |
| `BROADCAST_CONNECTION`                      | `log`; registra eventos sem entrega ao navegador.                                                                   |
| `FILESYSTEM_DISK`                           | `local`; configure outro disco somente quando necessário.                                                           |
| `REDIS_HOST`, `REDIS_CLIENT`                | Só necessários ao usar Redis: host real e `phpredis` com extensão instalada ou `predis`, já disponível no Composer. |

Em `qa`, homologação e produção, o aplicativo pode carregar configurações criptografadas do AWS Parameter Store. Configure `PARAMETER_STORE_PATH_QA`, `PARAMETER_STORE_PATH_HML` ou `PARAMETER_STORE_PATH_PRODUCTION` no ambiente de inicialização. Acesso à AWS pode usar as variáveis de credenciais ou a cadeia padrão do SDK, incluindo IAM roles; ambientes sem caminho configurado não consultam o serviço.

Credenciais explícitas usam `AWS_ACCESS_KEY_ID` e `AWS_SECRET_ACCESS_KEY`, com `AWS_SESSION_TOKEN` quando forem temporárias. Depois de carregar os parâmetros, o provider recarrega a configuração e atualiza a requisição de console para gerar links com o `APP_URL` efetivo. Os aliases `hml`/`homolog` e `prod`/`production` usam os caminhos correspondentes; não inclua segredos nos arquivos versionados.

Cadastre o diretório no Herd (ou use um diretório já estacionado). Para vincular o diretório atual com TLS e atualizar `APP_URL`:

```bash
herd link --secure --update-env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
npx --no-install husky
php artisan boost:install --guidelines --skills --mcp
```

Na etapa **Which third-party AI guidelines/skills would you like to install?**, selecione todos estes pacotes:

```text
maatwebsite/excel,pestphp/pest-plugin-agent,spatie/laravel-sluggable,barryvdh/laravel-debugbar
```

Na etapa **Which integrations would you like to configure for Boost?**:

- Se o projeto usa Laravel Sail, selecione `Laravel Sail`.
- Se o projeto não usa Laravel Sail, selecione `None`.
- Nunca selecione `Laravel Cloud`.

Na etapa **Which AI agents would you like to configure?**, selecione:

```text
codex
```

O instalador do Boost é interativo. Use `Espaço` para marcar as opções e `Enter` para confirmar:

1. Marque todos os pacotes listados acima e não selecione `None`.
2. Marque todos os agentes listados acima.
3. Escolha a integração conforme o uso de Sail e nunca selecione Laravel Cloud.
4. A opção `--mcp` instala a configuração do servidor MCP do Laravel Boost para os agentes selecionados.

`codex` é a seleção local adotada nesta base. Se também utilizar OpenCode, selecione `opencode` no instalador; não o configure apenas por existir no ERP. A seleção efetiva fica no `boost.json` local. Codex e OpenCode usam `AGENTS.md` e `.agents/skills` nesta versão do Boost; a configuração MCP tem destino próprio para cada agente.

Gere a chave apenas para uma instalação nova; não substitua a chave de uma aplicação existente. No Windows, a criação do link de storage pode exigir as permissões locais para links simbólicos. `npm ci --ignore-scripts` não instala navegadores nem ativa o Husky automaticamente; os comandos explícitos evitam essa ambiguidade.

### Atualização de uma instalação existente

Preserve `.env`, `APP_KEY`, storage e dados. Depois de revisar as migrations pendentes e preparar backup/restauração, instale os locks com os comandos acima, compile os assets e aplique somente as migrations pendentes. Em homologação/produção, use `php artisan migrate --force`, com as credenciais e os segredos de provisionamento do ambiente, e reinicie os workers após publicar o código. Não repita `key:generate` nem use `migrate:fresh` como atualização.

Uma instalação MySQL/SQLite existente exige projeto próprio de conversão e validação; trocar `DB_CONNECTION` não transfere dados nem torna as migrations PostgreSQL aplicáveis ao banco antigo.

O Herd serve a aplicação: não execute `php artisan serve`. Para atualizar assets durante o desenvolvimento, use `npm run dev` em outro terminal. O login fica em `/admin/login`; `/dashboard` e `/admin/dashboard` exigem os respectivos acessos.

### 2. Filas e agendamento

Os nomes lógicos estão em [Queues.php](app/Enums/Queues.php); a resolução está em [QueueNames.php](app/Support/QueueNames.php).

| Fila            | Trabalho implementado                              |
| --------------- | -------------------------------------------------- |
| `high_priority` | Alertas críticos para Discord, quando habilitados. |
| `low_priority`  | Notificações de convite e recuperação de senha.    |
| `long_timeout`  | Execução controlada de comandos Artisan.           |

Com `QUEUE_CONNECTION=database` e `QUEUE_PREFIX` vazio, em qualquer ambiente:

```bash
php artisan queue:work database --queue=high_priority,low_priority,long_timeout --sleep=1 --timeout=600 --tries=3
```

Um worker processa essa lista em ordem de prioridade; workers separados evitam que comandos longos atrasem as outras filas. No Windows sem `pcntl`, não conte com o timeout de processo do worker como limite rígido; o executor Artisan também limita seu subprocesso.

`QUEUE_PREFIX` é opcional. Quando ausente, produtores e consumidores usam os nomes originais. Com `QUEUE_PREFIX=minha-app` e `APP_ENV=production`, os nomes físicos são `minha-app_production_high_priority`, `minha-app_production_low_priority` e `minha-app_production_long_timeout`. Use os nomes físicos em `--queue`, com o mesmo prefixo e ambiente dos produtores. Prefixo e ambiente aceitam apenas letras, números, hífens e sublinhados. O dispatcher rejeita jobs sem fila explícita e a fila `default`; o fallback `notifications` das conexões não integra a lista de filas do worker acima. Use um prefixo ou backends isolados quando aplicações compartilham a mesma infraestrutura de filas.

**Auditoria tem configuração própria:** [config/audit.php](config/audit.php) habilita fila, usa `AUDIT_QUEUE_CONNECTION=database` por padrão e envia para `low_priority` sem prefixo, ou para `<QUEUE_PREFIX>_low_priority` quando ele estiver configurado, sem acrescentar `APP_ENV`. Consuma-a separadamente na conexão configurada; por exemplo, para o prefixo anterior e auditoria em database:

```bash
php artisan queue:work database --queue=minha-app_low_priority --sleep=1 --timeout=60 --tries=3
```

Não presuma que alterar `QUEUE_CONNECTION=redis` também muda a conexão da auditoria.

As filas usam os workers nativos do Laravel. Para Redis, configure a conexão e execute `php artisan queue:work redis` com os nomes físicos em `--queue`. As reservas de database, Redis e Beanstalkd têm `retry_after` mínimo de 630 segundos; a visibilidade do SQS precisa ser ajustada no serviço. Configure o timeout do consumidor abaixo da reserva, como os 600 segundos do exemplo acima.

[routes/console.php](routes/console.php) agenda `email:maintain-notifications` a cada cinco minutos, com proteção contra sobreposição. Em desenvolvimento, o provider registra `queue:listen` com as filas resolvidas e `schedule:work --whisper`; em ambientes publicados, configure a execução de `schedule:run` pelo agendador do host. A operação usa workers nativos, sem Horizon instalado.

## Funcionalidades e integrações

| Recurso                      | Estado nesta base                                                                                                                                                                                               |
| ---------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Autenticação e administração | Implementados: login, cadastro público, recuperação de senha, verificação de e-mail, perfil, usuários, convite de primeiro acesso, perfis/permissões e dashboards protegidos.                                   |
| Suporte                      | Implementados: persistência e triagem de alertas de erro e executor Artisan com autorização, restrição por IP e lista de comandos/argumentos permitidos por ambiente.                                           |
| Consultas                    | Implementadas: usuários, perfis, estados, CEP via ViaCEP e CNPJ via serviço público CNPJ.ws; serviços externos dependem de disponibilidade e limites do provedor.                                               |
| Auditoria                    | Integrada aos modelos auditáveis, habilitada e enfileirada por padrão; veja a configuração de consumo acima.                                                                                                    |
| API Sanctum                  | Ativa e mínima: `GET /api/user` exige `auth:sanctum` e retorna `UserResource`; não há API de negócio completa.                                                                                                  |
| Broadcast                    | Autorização de canais registrada e canal privado `App.Models.User.{id}` limitado ao próprio usuário. O driver padrão `null` não entrega eventos ao navegador.                                                   |
| Echo/WebSockets              | Preparados: `laravel-echo` e `pusher-js` instalados, sem cliente Echo inicializado. Um driver real exige dependência PHP apropriada, servidor/credenciais, eventos, canais autorizados e configuração frontend. |
| Discord                      | Integração implementada, desligada por padrão. Exige `DISCORD_ALERTS_ENABLED=true`, `DISCORD_ALERT_WEBHOOK_URL` válido e consumo de `high_priority`; limites e retentativas estão em `config/alerts.php`.       |
| Brevo                        | Transporte implementado. Ative com `MAIL_MAILER=brevo` e `BREVO_API_KEY`; mantenha segredos fora do Git.                                                                                                        |
| S3                           | Adaptador e disco preparados. Selecione o disco e configure credenciais, região, bucket e endpoint reais; os valores de exemplo não configuram uma conta AWS.                                                   |
| Log Viewer                   | Integrado em `/logs`, com autorização administrativa; `LOG_VIEWER_ENABLED=false` desativa o recurso.                                                                                                            |
| Laravel AI SDK 1.3.0         | Dependência, configuração e schema de conversas preparados. Não há Agent de negócio pronto; ativar uma capacidade exige provedor, credenciais, implementação e testes próprios.                                 |
| Laravel Excel 4.0.6          | Dependência preparada, sem fluxo de importação/exportação de negócio. Cada caso exige suas classes e validações.                                                                                                |
| Sluggable 4.0.6              | Configuração preparada; cada modelo que usar slugs precisa definir geração, coluna/index e binding de rota.                                                                                                     |
| Browsershot 5.4.2            | Configuração no container preparada; não é um fluxo pronto de geração de documentos. Usa Node e Puppeteer do projeto.                                                                                           |

A central e o histórico de notificações são restritos ao usuário autenticado, com carregamento adiado, paginação e ações de visualização, leitura e exclusão lógica. Filtros de listagens usam rascunho e aplicação explícita; selects compartilhados suportam bindings diferidos e parâmetros dependentes, conforme o [catálogo de componentes](.ai/skills/remsoft-ui-components/references/component-catalog.md).

E-mails enfileirados passam pelo controle central de uma mensagem por segundo por ambiente e pelo rastreio de tentativas reais de transporte. Repetir o mesmo job aceito não reenvia a mensagem; interrupções podem ficar com resultado incerto. Aceitação pelo transporte não comprova chegada à caixa do destinatário. A manutenção agendada acompanha falhas e limpeza de registros concluídos; a retenção configurável do rastreio é de 30 dias por padrão, conforme [config/mail.php](config/mail.php). Autenticação também tem limites próprios de solicitação de e-mails.

A biblioteca de uploads valida conteúdo/MIME/extensão e tamanho, limita dimensões de imagens, aplica orientação EXIF e converte imagens para WebP. Ela oferece Actions e componentes reutilizáveis, sem importar telas ou regras de catálogo do ERP. A persistência monetária, exportação e documentos históricos não ganham um fluxo de negócio apenas pela presença desses utilitários.

O nome da aplicação e os títulos usam `APP_NAME` do ambiente. Esta base não inclui um módulo de personalização de identidade visual por empresa.

Para usar Browsershot após a instalação sem scripts, execute `npx puppeteer browsers install chrome`. Os caminhos opcionais `BROWSERSHOT_CHROME_PATH`, `BROWSERSHOT_NODE_BINARY`, `BROWSERSHOT_NODE_MODULE_PATH` e `BROWSERSHOT_BIN_PATH` são aplicados ao resolver `Browsershot` pelo container; vazios preservam os padrões descritos em `.env.example`.

A instalação de um pacote não ativa um recurso de negócio. Novos fluxos precisam de configuração explícita, autorização e testes dedicados.

## Provisionamento e segurança

- `php artisan migrate --seed` segue [DatabaseSeeder.php](database/seeders/DatabaseSeeder.php). Em `production` e `homolog`, usa o provisionamento de produção; nos demais ambientes, inclui contas locais de desenvolvimento. Não publique essas contas nem use o seeder local em um ambiente exposto.
- Para criar as contas iniciais em `production`/`homolog`, forneça `PRODUCTION_ADMIN_PASSWORD` e `PRODUCTION_SUPPORT_PASSWORD` por um canal de segredos. Cada segredo deve ter de 16 a 72 bytes, sem bytes nulos; a validação também exige ao menos 16 bytes após remover espaços nas extremidades. Contas existentes, inclusive excluídas logicamente, são preservadas: repetir o seeder não troca senhas nem restaura contas.
- Use `APP_DEBUG=false`, ambiente correto e HTTPS em produção. Mantenha `.env`, chaves, webhooks e senhas fora do controle de versão; nunca copie credenciais reais para testes ou exemplos públicos.
- Configure `ARTISAN_EXECUTOR_ALLOWED_IPS` para o acesso autorizado ao executor. Revise [config/artisan-executor.php](config/artisan-executor.php): a lista de IPs não substitui políticas de acesso nem a lista de combinações permitidas de comandos e argumentos.
- Planeje banco, storage, filas, scheduler e reinício dos workers no deploy. Os hooks locais não substituem a execução dos gates no ambiente de integração.

## Testes, formatação e qualidade

Mantenha testes de comportamento crítico: autorização, isolamento de dados, validação, transações, cálculos, filas, notificações, uploads e integrações. Não crie testes apenas para repetir declarações do framework, configuração de ferramentas, CSS ou atingir um percentual. A suíte de browser foi removida; não há instalação de Chromium nem gate de navegador para testes.

Não crie testes dedicados a migrations, seeders, factories, bootstrap ou provisionamento de infraestrutura. Preserve a preparação necessária aos testes comportamentais.

`phpunit.xml` utiliza PostgreSQL no banco isolado `rsp_testing`; `phpunit-ci.xml` utiliza `rsp_ci_testing`. Configure acesso a esses bancos de teste e nunca aponte as suítes para dados reais. Unit puro não inicia Laravel; os arquivos/grupos que precisam da aplicação ou de persistência têm opt-ins em `tests/Pest.php`. HTTP e processos via Laravel não simulados são bloqueados por padrão; integrações reais autorizadas devem ter exceção local restaurada em `finally`.

Em worktrees Git, o runner usa o banco definido no `.env.testing` local, exigindo o nome do banco da aplicação seguido de `_testing`. Isso vale para testes focados e para `composer test:full`; os processos paralelos recebem o sufixo nativo `_test_N`. O setup do Orca prepara esses nomes e extensões sem restaurar arquivos do Git, trocar uma chave existente ou executar `migrate:fresh`. Seeds são executados automaticamente apenas quando o próprio setup cria o banco da aplicação; em um banco existente, execute-os somente quando necessário.

As execuções PHP usam sempre TIA, também habilitada por padrão em `tests/Pest.php`. A primeira execução precisa de PCOV ou Xdebug com cobertura habilitada para gravar o mapa; as seguintes executam os testes afetados e reutilizam resultados válidos dos demais. Use `--tia --fresh` para reconstruir o mapa após mudanças amplas. Resultado reaproveitado não significa execução nova de cada teste. Não desative TIA silenciosamente quando o driver não estiver disponível.

| Comando                                             | Finalidade                                                                                                                               |
| --------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------- |
| `composer test:focused -- --filter=CreateUser`      | Testes PHP afetados com TIA, via Artisan.                                                                                                |
| `composer test:full`                                | Unit/Feature com TIA e `phpunit-ci.xml`; o nome mantém compatibilidade com os comandos existentes.                                       |
| `composer test:js` / `npm run test:js`              | Testes JavaScript de comportamento.                                                                                                      |
| `composer analyse`                                  | PHPStan/Larastan em `level: max`, com Carbon e bleeding edge. Inclui consumidores de teste das traits TALL para analisar seus contratos. |
| `composer format` / `composer format:check`         | Pint com escrita / verificação.                                                                                                          |
| `php vendor/bin/pint --dirty --format agent`        | Formata PHP alterado.                                                                                                                    |
| `npm run format` / `npm run format:check`           | Prettier com escrita / verificação.                                                                                                      |
| `npm run build`                                     | Build de produção.                                                                                                                       |
| `composer refactor:check`                           | Rector em dry-run.                                                                                                                       |
| `composer coverage:code` / `composer coverage:type` | Relatórios opcionais de cobertura PHP/tipos, com TIA e sem percentual obrigatório.                                                       |
| `npm run coverage:js`                               | Relatório opcional de linhas, ramos e funções JS, sem percentual obrigatório.                                                            |
| `composer audit:composer` / `composer audit:npm`    | Auditorias de dependências.                                                                                                              |
| `composer quality:check`                            | Build/check frontend, PHP com TIA, JS, auditorias, Pint, PHPStan e Rector.                                                               |

`composer test` e `composer test:ci` chamam `quality:check`. Cobertura é diagnóstico, não um gate de 100%. Os relatórios de cobertura e o comando global `npm run format:check` são independentes do pipeline.

## Contribuição e ferramentas

O [pipeline GitLab](.gitlab-ci.yml) tem três etapas:

| Etapa       | Acionamento                             | Resultado                                                                                     |
| ----------- | --------------------------------------- | --------------------------------------------------------------------------------------------- |
| Verificação | Manual em merge requests                | Build frontend, auditorias, Pint, PHPStan, Rector, testes JS e PHP com TIA e relatório JUnit. |
| Build       | Manual em `develop`, `homolog` e `main` | Instala dependências dos locks, compila assets e produz um ZIP por projeto/branch/data.       |
| Upload      | Após o build                            | Envia o ZIP ao S3 correspondente: QA, homologação ou produção.                                |

Configure no GitLab `AWS_ACCESS_KEY_ID_{QA,HML,PROD}`, `AWS_SECRET_ACCESS_KEY_{QA,HML,PROD}` e `AWS_S3_BUCKET_{QA,HML,PROD}`, além da região usada pelo AWS CLI. `DISCORD_WEBHOOK_URL` é opcional para avisos de falha do CI e é distinto do webhook de alertas da aplicação.

Build/upload nas branches não exigem a verificação de merge request; um ZIP gerado não comprova testes aprovados. O upload apenas distribui o pacote, sem atualizar servidores, aplicar migrations ou reiniciar workers. A configuração foi validada por lint; execução real do runner PostgreSQL 16 e dos uploads precisa de comprovação operacional própria. A execução local em PostgreSQL 18.6 não substitui essa validação.

Use branches no formato aceito pelo hook, por exemplo `task/RSP-9-readme-final`, com os prefixos `feature`, `epic`, `bugfix`, `hotfix`, `enhancement` ou `task`, chave YouTrack e descrição com letras, números e hífens. Commits diretos em `main`/`develop` são bloqueados; o hook acrescenta a chave da tarefa ao assunto quando necessário.

As fontes próprias de orientação dos agentes permanecem versionadas em [.ai/rules](.ai/rules/index.md), `.ai/guidelines` e `.ai/skills`. `AGENTS.md` e as skills em `.agents/skills` são destinos locais gerados pelo Laravel Boost e não são versionados. A skill própria `remsoft-ui-components` mantém sua fonte em `.ai/skills`.

Edite skills próprias em `.ai/skills/<nome>/SKILL.md` e seus arquivos de referência. Não edite a cópia em `.agents/skills`: o Boost pode usar um link simbólico ou uma cópia, conforme o sistema e as permissões. Skills fornecidas por pacotes continuam sendo mantidas pelos respectivos fornecedores; não copie todas elas para `.ai/skills`.

Depois da instalação inicial, regenere usando as seleções locais existentes:

```bash
php artisan boost:update --no-discover --no-interaction
```

Esse comando atualiza guidelines e skills; para mudar agentes, integrações ou configuração MCP, execute novamente `boost:install`. Antes de regenerar, preserve eventuais alterações locais nos destinos. Depois, confira a saída, a presença das skills instaladas, a correspondência da skill própria com sua fonte e o `git diff`: a atualização dos destinos não deve alterar as fontes versionadas. Não remova ou exclua guidelines próprias da geração implicitamente.

O Laravel Boost já é dependência de desenvolvimento; o servidor MCP inicia com `php artisan boost:mcp`. `boost.json`, `.mcp.json`, `opencode.json` e os diretórios locais dos agentes ficam no `.gitignore`. Configure os agentes instalados com o comando `boost:install` descrito na instalação, mantendo caminhos de máquina e segredos fora do Git.
