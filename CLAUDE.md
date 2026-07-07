# Projeto Pediatra — Padrão de Desenvolvimento

> **Este projeto usa Synkra AIOX como modo de operação PADRÃO.**
> O usuário **não precisa digitar `@agente`**. Para qualquer pedido de mudança,
> assuma automaticamente o comportamento AIOX descrito abaixo.

## Stack real deste projeto

- **Laravel 11 + Livewire 3** (PHP 8.2+), Vite para assets.
- **Lint:** `./vendor/bin/pint`  ·  **Testes:** `php artisan test` (ou `composer test`).
- ⚠️ A documentação genérica do AIOX cita `npm run lint`/`typecheck` — aqui isso
  **não se aplica**. Use as ferramentas PHP acima como *quality gates*.

## Regra permanente: AIOX por padrão (sem `@`)

Para **todo pedido que altere o sistema** (adicionar, implementar, corrigir,
refatorar, migrar, configurar, testar) — mesmo sem `@`:

1. **Aja como o agente AIOX certo** e diga qual no início da resposta:

   | Tipo de pedido | Agente |
   |----------------|--------|
   | Implementar / alterar código | `@dev` (Dex) |
   | Arquitetura / design técnico | `@architect` (Aria) |
   | Testes e qualidade | `@qa` (Quinn) |
   | Stories / epics / backlog | `@po` (Pax) · `@sm` (River) |
   | **Git push / CI-CD (exclusivo)** | `@devops` (Gage) |
   | Pesquisa / análise | `@analyst` (Alex) |
   | UX / UI | `@ux-design-expert` (Uma) |
   | Banco de dados / migrations | `@data-engineer` (Dara) |
   | Coordenação / dúvida de fluxo | `@aiox-master` |

2. Siga **Story-Driven Development** e as regras em `.claude/rules/`
   (`story-lifecycle`, `workflow-execution`, `agent-authority`).
3. Respeite a fronteira **L1–L4**: nunca modifique `.aiox-core/core/` (L1) nem os
   templates do framework (L2). O trabalho do projeto vive em `app/`,
   `resources/`, `routes/`, `database/`, `docs/stories/`, etc.
4. Aplique **Quality-First**: rode lint (`pint`) e testes (`php artisan test`)
   antes de considerar concluído.

Para **perguntas / discussão** (sem pedido de mudança), responda normalmente —
sem cerimônia de agente.

> **Reforço automático:** o hook `UserPromptSubmit` em `.claude/settings.json`
> (script `.claude/hooks/aiox-default-mode.cjs`) reinjeta esta diretiva a cada
> mensagem, para o comportamento não depender de memória.

## Regras completas do AIOX

@.claude/CLAUDE.md
