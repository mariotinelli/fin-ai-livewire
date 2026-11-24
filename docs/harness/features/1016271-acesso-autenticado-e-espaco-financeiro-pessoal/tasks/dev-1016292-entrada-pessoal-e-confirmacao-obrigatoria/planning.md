# Plano — DEV 1016292: entrada pessoal e confirmação obrigatória

## Identidade, fontes e decisão

- DEV #1016292, pai #1016271; [task.md](task.md), [requisito](../../feature.md) e [condições CT-001 a CT-012](../../slices/condicoes-teste-r002.md).
- Preparado no pedido `$ralph 1016292`, apresentado na conversa e aprovado pelo usuário com “aprovado”. Autorizada a execução pelo Codex e o commit após os gates, sem push e sem alterar Redmine.
- Dependência: usuário confirmou nesta conversa que a QA #1016288 foi concluída. A fundação F01 está integrada ao HEAD inspecionado `8fbd241`.
- Git inicialmente limpo, branch `feature/1016292-acesso-atenticado-entrada-pessoal-e-confirmacao-obrigatoria`. Preservar alterações posteriores e alheias. Sem push e sem alterações no Redmine.

## Objetivo e limites

Concluir a jornada pessoal real de cadastro, entrada, confirmação do endereço atual, reenvio, recuperação, saída e retomada autorizada, aproveitando a autenticação e a identidade FinAI existentes. Conta pendente deve reencontrar a orientação de confirmação sem perder o acesso permitido ao perfil e às demais funções não financeiras.

Não implementar transações, indicadores, chat, IA, novos privilégios ou gestão de dispositivos. Não reconstruir F01 nem autenticação. Preservar entradas administrativas e de suporte e seus comportamentos. Proteger a entrada financeira existente sem bloquear indiscriminadamente o grupo de rotas pessoais; as Features consumidoras protegerão também seus próprios recursos futuros.

## Evidência técnica e estratégia

`routes/web.php` encaminha visitante por `dashboard`; `routes/auth.php` contém redirecionamento legado `/login` para `/admin/login`. O login pessoal existe em `/cliente/login`, mas a view compartilhada de login não oferece cadastro. Tornar a entrada principal pessoal e o cadastro/recuperação encontráveis, respeitando as regras de URLs por tipo e mantendo os fluxos compartilhados de recuperação. Inspecionar referências e testes de URLs antes de ajustar rotas; não criar outro login raiz.

`RegisteredUserController` valida nome 3–191, e-mail até 191, senha confirmada até 191 com `Password::defaults()`, usa `CreateUser` com tipo Customer e emite Registered antes de autenticar. O redirecionamento atual vai ao dashboard mesmo pendente; falha no pedido de notificação pode interromper a resposta depois da criação. Normalizar e-mail antes de validar/consultar, preservar allowlist e conta única sem privilégios e apresentar recuperação da conta já criada quando falhar a solicitação de envio. Não confundir pedido aceito na fila com entrega na caixa postal.

`BaseLogin` autentica por tipo, limita cinco tentativas e regenera sessão. Não distingue pendência na saída e consome o destino pretendido imediatamente. Preservar limites, lembrar acesso e recusas por área, acrescentando o encaminhamento pessoal pendente e preservando uma retomada segura. `bootstrap/app.php` escolhe login por área; conferir links de confirmação abertos sem autenticação para manter o canal pessoal correto e o destino necessário sem permitir troca silenciosa de titular.

`User` implementa MustVerifyEmail. `VerifyEmailController` usa EmailVerificationRequest, evita repetir Verified e retoma por IntendedDestination. As rotas exigem auth, assinatura e throttle. Links recusados precisam de orientação para novo pedido, sem aceitar assinatura/hash/ID incorretos nem afetar outra conta. Tratar o erro na fronteira pertinente, sem mudar genericamente todos os erros 403 ou assinaturas da aplicação. Preservar idempotência e verificar links após troca de endereço.

`IntendedDestination` filtra origem e prefixo, mas não demonstra disponibilidade/autorização da rota. Fortalecer a retomada pessoal conforme o aceite, sem navegar para destino inexistente, indisponível, alheio ou sem permissão. Preservar consumidores administrativos/suporte; não executar mutações ou requisições internas para testar um destino. Se necessário, manter a solução restrita ao fluxo pessoal, evitando ampliar a API compartilhada sem consumidor concreto.

`EmailVerificationNotificationController` solicita envio sem tratar falha; a view afirma que o link acabou de ser enviado. Reutilizar notificação enfileirada `VerifyEmailNotification`, que já exige envio após commit e reavalia o destinatário. Acrescentar feedback coerente, falha corrigível e reenvio/saída, mantendo throttle de um pedido por minuto e cinco por hora, e cadastro de três por hora. Não alterar a arquitetura de entrega de e-mail nem garantir resultados assíncronos ainda não observados.

`ForgotPassword` preserva resposta genérica e contexto, mas consulta e-mail sem a normalização já usada no identificador de limite. `ResetPassword` normaliza e-mail, verifica token antes de política de senha e retorna ao login do tipo. `AppServiceProvider` define mínimo de oito, maiúscula/minúscula, número, símbolo e recusa de senha comprometida. Reutilizar essa política e preservar tokens, limites e não enumeração. Recuperação não confirma endereço.

`UpdateOwnProfile` normaliza e-mail, preserva diferenças só de caixa/espaços e usa transação. `UserObserver` retira confirmação na mudança real e solicita notificação após commit. `UpdateProfileInformationForm` permite editar o perfil e anuncia sucesso após a Action. Conferir falha de solicitação após persistência e a retomada de confirmação do endereço atual; preservar identidade, dados e confirmação ao alterar somente nome. Não duplicar responsabilidade nem enviar duas notificações.

`Logout` encerra sessão atual, invalida sessão e retorna ao login do tipo. Reutilizar esse comportamento e demonstrar troca de conta sem contexto herdado. Testes existentes dedicados cobrem controllers, BaseLogin e logins especializados, recuperação, perfil, Actions, observer, notificações e destino pretendido. Atualizar regressões no responsável, sem criar teste amplo de toda a aplicação.

## Referência visual e riscos

V01: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, inspecionada no planejamento. Fundo #F5F7F8, superfície branca, texto #172622, secundário #52615C, verde #145C46, borda #D6DFDB, destaque #E4F0E9, sucesso #146345 e erro #A12B36; Georgia nos títulos, system-ui no corpo, controles com raio 8px, painéis 16px, alvos de ação de pelo menos 44px. Consumir tokens semânticos de `resources/css/themes.css`, layout guest e componentes x-ui existentes. Não há mockup individual obrigatório para cada tela de acesso: herdar F01.

Comparar entrada pessoal, cadastro, confirmação/reenvio, recuperação/redefinição e perfil afetado em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080. Cobrir estados aplicáveis de espera, validação, processamento, falha, sucesso e limitação; teclado, foco, rótulos e ações finais alcançáveis, com a barra de ambiente. Screenshots isolados não substituem comparação nem exercício dos fluxos.

Riscos: perder o link válido na autenticação; loop de confirmação; liberar dashboard por cookie lembrado; bloquear perfil; confundir erro de fila com perda da conta; reutilizar destino de outra conta; regressão nos consumidores compartilhados; sinais de sucesso falsos; alteração de e-mail confirmada pelo link antigo; alterações de URL quebrarem links reais. Cobrir esses riscos com testes de aplicação e evidência interativa adequada.

## Baseline e verificadores

Contexto de 20/11/2026: PowerShell na raiz desta worktree, fora do executor, PHP 8.4.28, Node 26.1.0. `composer show --direct` confirmou Laravel 13.40.0, Livewire 4.4.8, Pest 5.3.5, Agent 5.0.0 e Browser 5.2.0. package.json declara Tailwind 4, Vite 8, Playwright e Puppeteer. Git Bash, Codex e PowerShell disponíveis. Documentação consultada via Boost; skills Livewire, Pest Agent e práticas de testes consultadas durante inspeção.

Comando obrigatório do gate Testes, também usado para observar o baseline:

```powershell
$ErrorActionPreference = 'Stop'
$taskTempDirectory = Join-Path $env:LOCALAPPDATA 'Temp/finai-1016292-quality'
New-Item -ItemType Directory -Path $taskTempDirectory -Force | Out-Null
$env:TEMP = $taskTempDirectory
$env:TMP = $taskTempDirectory
composer quality:check
exit $LASTEXITCODE
```

Resultado do baseline: `composer quality:check` terminou com falha no último passo, Rector dry-run (código 2 do script). Passaram build, checagem CSS, 1.924 testes PHP com 6.751 asserções (TIA fresh graph, 168,466s), 271 testes JavaScript, auditorias Composer/npm sem vulnerabilidades, Pint e PHPStan com zero erros. Rector não relatou erros de análise, mas exigiu uma linha em branco antes de `$execution` em `tests/Feature/Jobs/ExecuteArtisanCommandJobTest.php`, no primeiro teste. Conferência de `git show HEAD:...` confirmou que a ausência já está no HEAD inicial; nenhuma fonte foi alterada pelo baseline. Incluir no Dev somente essa correção de formatação preexistente, sem mudar a lógica ou o verificador. Não repetir o agregado antes da implementação apenas para reproduzir a mesma falha. O gate Testes continua exigindo todos os passos aprovados. Não houve coleta visual/interativa neste planejamento; integra Dev e Validação.

O agregado inclui build, Prettier CSS, suíte PHP paralela com `--tia`/phpunit-ci.xml, testes JavaScript, auditorias Composer/npm, Pint em checagem, PHPStan e Rector dry-run. Não substituir ou omitir verificadores. A TIA pode reutilizar resultados: distinguir replay de execução nova. Usar testes afetados com `--tia` no Dev; para nova observação necessária, `--tia --fresh`. Se modificar PHP, rodar `vendor/bin/pint --dirty --format agent` antes de concluir.

Antes da primeira edição, o Dev executa somente `npm run build`, menor conferência aplicável entre os verificadores previstos; agregado e suíte completa pertencem a Testes, após revisão. Aplicar TEMP/TMP acima também no processo Dev quando necessário. O baseline desta conversa não comprova permissões dentro do executor.

Aprendizados operacionais documentados na fornecedora 1016284: TEMP/TMP exclusivos evitam stubs de outra worktree; Pint paralelo já teve timeout interno de 120s. O executor instalado ainda usa dois `tail -c 12000`, que podem cortar UTF-8 no diagnóstico. Antes de iniciar, usar cópia local no diretório Git com apenas esses recortes substituídos por `tail -n 80`, preservando conteúdo restante, gates, hooks, testes e permissões. Não alterar skills instaladas. Investigar falhas proporcionalmente, sem repetir condições conhecidamente problemáticas.

## Fase 1 — Jornada pessoal completa com confirmação do endereço atual

### Dev

1. Conferir instruções/regras dos caminhos efetivamente afetados e skills pertinentes; executar a conferência mínima. Preservar UTF-8 e trabalho existente. Corrigir somente a linha em branco indicada pelo Rector no teste preexistente `tests/Feature/Jobs/ExecuteArtisanCommandJobTest.php`, sem alterar comportamento, e rodar o teste afetado com `--tia` após a edição.
2. Ajustar entrada principal, links e contexto pessoal, normalização de e-mail e cadastro seguro, preservando validações e limites. Encaminhar cadastro/login pendente à confirmação e proteger a entrada financeira já existente, inclusive em acesso lembrado; manter perfil e funções não financeiras permitidas.
3. Completar confirmação/reenvio e erros de links, idempotência, autenticação necessária e retomada própria disponível/autorizada. Preservar assinatura, expiração e limitação; falhas na solicitação de envio deixam conta utilizável e sem sucesso falso.
4. Integrar recuperação, redefinição, alteração de e-mail, saída e troca de contas; preservar política de senha, resposta genérica, tokens e identidade. Ajustar somente lacunas demonstradas; não reimplementar comportamentos já corretos.
5. Atualizar/criar cobertura relevante por arquivo responsável conforme estrutura espelhada. Usar factories e fakes de notificações/filas/HTTP, relógio controlado e bancos isolados. Não disparar e-mails reais nem criar usuários persistentes na aplicação. Cobrir decisões e falhas relevantes sem testar declarações ou repetir a implementação.
6. Coletar evidência dos fluxos reais, duas contas e outro contexto de navegador, além da matriz visual e estados. Usar Pest Agent/Browser instalados e mecanismo de evidências existente; nenhuma suíte permanente de browser. Não iniciar servidor próprio; Herd já serve a aplicação. Capturas úteis em local ignorado, referenciadas no resumo e fora dos arquivos de commit. Ausência de evidência coletável é ação requerida.

Arquivos prováveis: `routes/{web,auth,customer}.php`, `bootstrap/app.php` se necessário ao contexto/erro específico, controllers Auth de cadastro/aviso/confirmação/reenvio, `app/Livewire/Auth/{BaseLogin,ForgotPassword,ResetPassword}.php`, `app/Support/Auth/IntendedDestination.php`, perfil/Action/observer apenas se exigido pelos erros demonstrados, views correspondentes de acesso e perfil, e testes dedicados espelhados. Ler regras adicionais antes de ampliar caminhos. Não alterar dependências, esquema de dados ou configurações globais por conveniência.

### Validação — outro processo, somente leitura

- CT-001–CT-003: entrada pessoal e cadastro/recuperação encontráveis; conta Customer única, sem convite ou privilégios; equivalência de e-mail entre fluxos; nome 3–191/e-mail válido até 191; senha confirmada até 191 no cadastro e política forte/comprometida em cadastro e redefinição.
- CT-004: cadastro/login pendente e lembrar acesso mostram confirmação do endereço atual; perfil e funções não financeiras continuam permitidos; entrada financeira existente não libera conta pendente.
- CT-005–CT-006: link próprio válido com/sem sessão, idempotência e evento único; somente destino próprio disponível/autorizado ou início pessoal; rejeitar externo, outra área, inexistente, sem permissão, expirado, adulterado, hash/ID alheios e endereço antigo. Links recusados orientam novo pedido sem confirmar conta indevida.
- CT-007: solicitação aceita sem garantia de entrega; falha após criação/reenvio e troca de e-mail informa estado real e permite retomar sem duplicação; limites atuais e nova tentativa após liberação preservados.
- CT-008–CT-010: credenciais inválidas e limites preservados; saída encerra sessão; recuperação genérica; token válido/expirado/inválido/utilizado; senha nova funciona e antiga falha; reset não confirma endereço; mudança real de e-mail retira confirmação, somente nome preserva; identidade e dados mantidos.
- CT-011: comparar composição, tokens, hierarquia, geometria, foco, legibilidade, rótulos e estados com V01/F01 em toda a matriz especificada, sem cortes/encobrimento e sem origem pessoal do design.
- CT-012: concluir jornada pelas telas e links reais, com duas contas distintas, troca e outro navegador/contexto; cada titular reencontra identificação e dados pessoais corretos sem depender de recursos financeiros futuros.
- Conferir regressões administrativas/suporte e consumidores de mudanças compartilhadas; evidências e testes existentes não são prova de novos cenários sem executar o comportamento pertinente.
- Defeitos ou evidências coletáveis retornam como rejected e ações específicas. blocked requer dependência externa impeditiva demonstrada. Não editar a entrega na revisão.

### Testes

Após aprovação independente, executar integralmente o bloco PowerShell acima e exigir saída 0. Preservar todos os verificadores; falha deve voltar ao Dev e ser seguida de nova Validação e Testes. Conferir testes afetados e modos de falha relevantes sem substituir a suíte pelo agente de verificação. Registro final distingue verificações executadas, TIA/replay e limitações reais.

### Commit

Entrega coerente: `feat: completa entrada pessoal e confirmação de e-mail (#1016292)`. Somente após Validação e Testes aprovados, commitar fontes/testes da fase e resumo consolidado neste plano com entrega, evidências e resultado do revisor. Sem push, Redmine, temporários ou arquivos alheios.

## Execução após aprovação

Uma execução do `ralph.sh` pelo Git Bash sem login na raiz desta worktree; backend Codex, modelo e permissões configurados no CLI preservados, revisor somente leitura. Passar caminho real deste plano, comando completo acima, `--test-shell powershell` e `--timeout-seconds 3600`, limite finito por processo compatível com a entrega e a suíte; prazos internos de ferramentas devem permitir resultado completo e acompanhamento incremental. Ajuste de invocação sem mudança de escopo não exige outra aprovação. Falha não autoriza ampliar acesso nem alterar configuração global.

A aprovação da proposta apresentada neste pedido autoriza iniciar o executor e os commits da fase, sem segunda confirmação. Acompanhar o mesmo processo até RALPH_FINISHED, informando início após RALPH_STARTED, gates observados e commits somente após RALPH_COMMIT. Em interrupção, preservar trabalho, conferir Git/plano/relatórios relevantes e investigar antes de outra execução; não iniciar cópia paralela.


### Resultado Ralph — Jornada pessoal completa com confirmação do endereço atual

- Entrega: Corrigida a formatação apontada pelo Rector no teste de login pessoal. As 66 asserções dos 10 testes de login passaram. Pint passou e Rector concluiu com zero alterações e zero erros. A fase está pronta para revisão e nova execução do gate Testes.
- Validação: outro processo codex, revisão 8, aprovada para a versão testada.
- Testes: verificadores aprovados; relatórios privados da execução, fase 1.
