<?php

namespace Drupal\schema_metatag_test\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaHasPartBase;

/**
 * A metatag tag for testing.
 *
 * @MetatagTag(
 *   id = "schema_metatag_test_has_part_multiple",
 *   label = @Translation("Schema Metatag Test HasPart"),
 *   name = "hasPartMultiple",
 *   description = @Translation("Test element"),
 *   group = "schema_metatag_test_group",
 *   weight = 0,
 *   type = "label",
 *   secure = FALSE,
 *   multiple = TRUE
 * )
 */
class SchemaMetatagTestHasPartMultiple extends SchemaHasPartBase {
    
}
