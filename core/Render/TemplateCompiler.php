<?php


namespace Core\Render;

class TemplateCompiler
{
    public function compile(string $templatePath, array $data = []): string
    {
        $compiledTemplate = $this->parseTemplate(file_get_contents($templatePath));

        extract($data);
        ob_start();
        eval('?>' . $compiledTemplate);
        return ob_get_clean();
    }

    private function parseTemplate(string $templateContent): string
    {
        // Пример замены синтаксиса {{ $var }} на <?php echo $var; ?.>
        $templateContent = preg_replace('/\{\{\s*(.+?)\s*\}\}/', '<?php echo $1; ?>', $templateContent);
        return $templateContent;
    }
}
