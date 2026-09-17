<?php

class UsuarioGetDto
{
    /**
     * @Name("id_usuario")
     * @Required
     * @Type("integer")
     */
    public $id_usuario;

    /**
     * @Name("id_publicador")
     * @Required
     * @Type("integer")
     */
    public $id_publicador;

    /**
     * @Name("id_congregacion")
     * @Required
     * @Type("integer")
     */
    public $id_congregacion;

    /**
     * @Name("id_perfil")
     * @Required
     * @Type("integer")
     */
    public $id_perfil;

    /**
     * @Name("nombre_completo")
     * @Required
     * @Type("string")
     */
    public $nombre_completo;

    /**
     * @Name("usuario")
     * @Required
     * @Type("string")
     * @UpperCase
     */
    public $usuario;

    /**
     * @Name("estatus_usuario")
     * @Required
     * @Type("integer")
     */
    public $estatus_usuario;

    /**
     * @Name("estatus_publicador")
     * @Required
     * @Type("integer")
     */
    public $estatus_publicador;

}

?>