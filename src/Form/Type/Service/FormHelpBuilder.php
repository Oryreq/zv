<?php

namespace App\Form\Type\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


class FormHelpBuilder
{
    private string $DARK_STYLES = 'border-radius: 4px;
                                   background-color: #171717;
                                   color: #FF9A62;
                                   padding: 1px 5px 1px 5px;
                                   margin-left: 8px;
                                   text-align: center';

    private string $rawHelpItems;


    public function buildHelpAsHtml(array $extensions): string
    {
        return $this->applyStylizedContainers(new ArrayCollection($extensions))
                        ->applyHelpFormContainer();
    }

    private function applyStylizedContainers(Collection $extensions): self
    {
        $this->rawHelpItems = $extensions
                                    ->map(function($extension) {
                                        return '<div style="' . $this->DARK_STYLES . '">'. $extension .'</div>';
                                    })
                                    ->reduce(function($accumulator, $value) {
                                        return $accumulator.''.$value;
                                    });
        return $this;
    }

    private function applyHelpFormContainer(): string
    {
        return '<div style="display: flex; text-align: center;">'. $this->rawHelpItems .'</div>';
    }
}