# Using an LLM for Refactoring

A language model can support refactoring by:

1. **Generating Updated PHP** – Provide code samples that follow modern PHP standards (namespaces, PSR style, exceptions) when prompted with existing functions or controllers.
2. **Suggesting Framework Migration** – Outline how legacy CakePHP code maps to structures in Laravel or Symfony. The model can propose class skeletons or routing definitions.
3. **Automated Documentation** – Produce inline documentation and comments for legacy methods to clarify behavior before rewriting.
4. **Unit Test Generation** – Draft PHPUnit test cases for controllers and models to validate behavior before and after changes.
5. **Incremental Translation** – When rewriting modules to an API, the model can help translate business logic into controller methods for the new framework.

Combining these capabilities with manual review allows gradual modernization while ensuring that existing features remain intact.
