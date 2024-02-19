<?php
class Macchina
{
    private $marca;
    private $modello;
    private $prezzo;
    private $descrizione;
    private $user;
    private $id;

    public function __construct(string $id, string $user, string $marca, string $modello, string $descrizione, int $prezzo)
    {
        $this->id = $id;
        $this->user = $user;
        $this->marca = $marca;
        $this->modello = $modello;
        $this->prezzo = $prezzo;
        $this->descrizione = $descrizione;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }
    public function getMarca(): string
    {
        return $this->marca;
    }
    public function setMarca(string $marca): void
    {
        $this->marca = $marca;
    }

    public function getModello(): string
    {
        return $this->modello;
    }

    public function setModello(string $modello): void
    {
        $this->modello = $modello;
    }

    public function getPrezzo(): float
    {
        return $this->prezzo;
    }

    public function setPrezzo(float $prezzo): void
    {
        $this->prezzo = $prezzo;
    }

    public function getDescrizione(): string
    {
        return $this->descrizione;
    }

    public function setDescrizione(string $descrizione): void
    {
        $this->descrizione = $descrizione;
    }
}