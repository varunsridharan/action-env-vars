<?php

function docker_image_slug() {
	$slug = get_env( 'REPOSITORY_SLUG' );
	return str_replace( 'docker-', '', strtolower( $slug ) );
}


if ( 'github-docker-release' === WORKFLOW_TYPE ) {
	set_action_env_not_exists( 'DOCKER_IMAGE_SLUG', docker_image_slug() );
}

if ( 'docker-release' === WORKFLOW_TYPE ) {
	set_action_env_not_exists( 'DOCKER_IMAGE_SLUG', docker_image_slug() );
}
