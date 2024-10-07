<?php

namespace Aysa\App\Models\Admin;

use Aysa\App\Models\Data\Aysa_Keyword;
use Aysa\App\Models\Data\Aysa_Rank_Tracker;
use Aysa\App\Models\Data\Aysa_Seo;
use Aysa\App\Models\Data\Repository\Keyword_Repository;
use Aysa\App\Models\Data\Repository\Rank_Tracker_Repository;
use Aysa\App\Models\Data\Repository\Seo_Repository;

if (!class_exists(__NAMESPACE__ . '\\' . 'Admin_Dashboard')) {
    class Admin_Dashboard extends Base_Model
    {
        private Seo_Repository $seo_repository;

        private Keyword_Repository $keyword_repository;

        private Rank_Tracker_Repository $rank_tracker_repository;

        public function __construct(
            Seo_Repository          $seo_repository = null,
            Keyword_Repository      $keyword_Repository = null,
            Rank_Tracker_Repository $rank_tracker_repository = null
        )
        {
            $this->seo_repository = $seo_repository ?? new Seo_Repository();
            $this->keyword_repository = $keyword_Repository ?? new Keyword_Repository();
            $this->rank_tracker_repository = $rank_tracker_repository ?? new Rank_Tracker_Repository();
        }

        /**
         * @param array $data
         *
         * @return void
         *
         * @throws \Exception
         */
        public function save_product(array $data)
        {
            //TODO validate inputted data
            $this->save_product_data($data);
            $this->save_aysa_data($data, 'product');
            $this->save_tracking_data($data);
        }

        /**
         * @param array $data
         *
         * @return void
         *
         * @throws \Exception
         */
        public function save_category(array $data)
        {
            //TODO validate inputted data
            $this->save_category_data($data);
            $this->save_aysa_data($data, 'category');
            $this->save_tracking_data($data);
        }

        /**
         * @param array $data
         *
         * @return void
         */
        private function save_product_data(array $data)
        {
            $product = wc_get_product($data['entity_id']);
            if (!empty($data['name'])) {
                $product->set_name($data['name']);
            }

            if (!empty($data['short_description'])) {
                $product->set_short_description($data['short_description']);
            }

            if (!empty($data['description'])) {
                $product->set_description($data['description']);
            }

            if (!empty($data['slug'])) {
                $product->set_slug($data['slug']);
            }

            if (!empty($data['single_image'])) {
                $product->set_image_id($data['single_image']);
            }
            if (!empty($data['single_image'])) {
                $product->set_gallery_image_ids($data['image_gallery']);
            }

            $product->save();
        }

        /**
         * @param array $data
         *
         * @return void
         */
        private function save_category_data(array $data)
        {
            $category = get_term($data['entity_id'], 'product_cat');
            if (!empty($data['name'] && !is_wp_error($category))) {
                $category->name = $data['name'];
                wp_update_term($data['entity_id'], 'product_cat', ['name' => $data['name']]);
            }

            if (!empty($data['slug'] && !is_wp_error($category))) {
                $category->slug = $data['slug'];
                wp_update_term($data['entity_id'], 'product_cat', ['slug' => $data['slug']]);
            }

            if (!empty($data['description'] && !is_wp_error($category))) {
                $category->description = $data['description'];
                wp_update_term($data['entity_id'], 'product_cat', ['description' => $data['description']]);
            }

            if (!empty($data['single_image'])) {
                update_term_meta($data['entity_id'], 'thumbnail_id', $data['single_image']);
            }
        }

        /**
         * @param array $data
         * @param string $type
         *
         * @return void
         *
         * @throws \Exception
         */
        private function save_aysa_data(array $data, string $type)
        {
            $aysa = $this->get_aysa($data);
            if ($this->seo_repository->get_entity_seo_data($aysa->get_entity_id(), $type)) {
                if (!$this->seo_repository->update($aysa)) {
                    throw new \Exception('Error updating seo data.');
                }
            } else {
                if (!$this->seo_repository->insert($aysa)) {
                    throw new \Exception('Error saving seo data.');
                }
            }
        }

        /**
         * @param array $data
         *
         * @return void
         *
         * @throws \Exception
         */
        private function save_tracking_data(array $data)
        {
            $seo_data = $this->seo_repository->get_entity_seo_data($data['entity_id'], $data['type']);
            $keyword_to_optimize = $seo_data->get_keyword_to_optimize();
            $second_keyword = $seo_data->get_second_keyword();

            if (isset($data['track']) && $data['track']) {
                if ($keyword_to_optimize && !$this->rank_tracker_repository->get_by_keyword($keyword_to_optimize->get_id())) {
                    $track_data = [
                        'seo_data_id' => $seo_data->get_id(),
                        'keyword' => $keyword_to_optimize->get_id(),
                        'aysa_keyword_id' => $keyword_to_optimize->get_aysa_keyword_id(),
                    ];
                    $rank_tracker = $this->get_rank_tracker($track_data);
                    if (!$this->rank_tracker_repository->insert($rank_tracker)) {
                        throw new \Exception('Error saving tracking data.');
                    }
                }

                if ($second_keyword && !$this->rank_tracker_repository->get_by_keyword($second_keyword->get_id())) {
                    $track_data = [
                        'seo_data_id' => $seo_data->get_id(),
                        'keyword' => $second_keyword->get_id(),
                        'aysa_keyword_id' => $keyword_to_optimize->get_aysa_keyword_id(),
                    ];
                    $rank_tracker = $this->get_rank_tracker($track_data);
                    if (!$this->rank_tracker_repository->insert($rank_tracker)) {
                        throw new \Exception('Error saving tracking data.');
                    }
                }
            }

            if (!isset($data['track']) || !$data['track']) {
                if ($keyword_to_optimize && $this->rank_tracker_repository->get_by_keyword($keyword_to_optimize->get_id())) {
                    $rank_tracker = $this->rank_tracker_repository->get_by_keyword($keyword_to_optimize->get_id());
                    if (!$this->rank_tracker_repository->delete($rank_tracker->get_id())) {
                        throw new \Exception('Error deleting tracking data.');
                    }
                }

                if ($second_keyword && $this->rank_tracker_repository->get_by_keyword($second_keyword->get_id())) {
                    $rank_tracker = $this->rank_tracker_repository->get_by_keyword($second_keyword->get_id());
                    if (!$this->rank_tracker_repository->delete($rank_tracker->get_id())) {
                        throw new \Exception('Error deleting tracking data.');
                    }
                }
            }
        }

        /**
         * @param array $data
         *
         * @return Aysa_Seo
         */
        private function get_aysa(array $data)
        {
            $aysa = new Aysa_Seo();
            $keyword_to_optimize = $this->get_keyword_to_optimize($data);
            $second_keyword = $this->get_second_keyword($data);

            $aysa->set_entity_id($data['entity_id'])
                ->set_type($data['type'])
                ->set_keyword_to_optimize_id($keyword_to_optimize)
                ->set_second_keyword_id($second_keyword)
                ->set_meta_description($data['aysa_meta_description'] ?? '')
                ->set_track($data['track'] ?? 0)
                ->set_meta_title($data['aysa_meta_title'] ?? '')
                ->set_meta_keywords($data['aysa_meta_keywords'] ?? '');

            return $aysa;
        }

        /**
         * @param array $data
         *
         * @return false|int
         */
        private function get_keyword_to_optimize(array $data)
        {
            $seo_data = $this->seo_repository->get_entity_seo_data($data['entity_id'], $data['type']);

            if ($seo_data->get_keyword_to_optimize_id() && $data['keyword']) {
                $keyword = $this->get_keyword($data, 'primary');
                $keyword->set_id($seo_data->get_keyword_to_optimize_id());

                return $this->keyword_repository->update($keyword);
            }

            if (!$seo_data->get_keyword_to_optimize_id() && $data['keyword']) {
                $keyword = $this->get_keyword($data, 'primary');

                return $this->keyword_repository->insert($keyword);
            }

            if ($seo_data->get_keyword_to_optimize_id() && !$data['keyword']) {
                $this->keyword_repository->delete($seo_data->get_keyword_to_optimize_id());

                return null;
            }

            return null;
        }

        /**
         * @param array $data
         *
         * @return false|int
         */
        private function get_second_keyword(array $data)
        {
            $seo_data = $this->seo_repository->get_entity_seo_data($data['entity_id'], $data['type']);

            if ($seo_data->get_second_keyword_id() && $data['second_keyword']) {
                $keyword = $this->get_keyword($data, 'secondary');
                $keyword->set_id($seo_data->get_second_keyword_id());

                return $this->keyword_repository->update($keyword);
            }

            if (!$seo_data->get_second_keyword_id() && $data['second_keyword']) {
                $keyword = $this->get_keyword($data, 'secondary');

                return $this->keyword_repository->insert($keyword);
            }

            if ($seo_data->get_second_keyword_id() && !$data['second_keyword']) {
                $this->keyword_repository->delete($seo_data->get_second_keyword_id());

                return null;
            }

            return null;

        }

        /**
         * @param array $data
         * @param string $position
         *
         * @return Aysa_Keyword
         */
        private function get_keyword(array $data, string $position)
        {
            $keyword = new Aysa_Keyword();
            if ($position == 'primary') {
                $keyword->set_value($data['keyword'] ?? '')
                    ->set_is_second_keyword(false);
            }

            if ($position == 'secondary') {
                $keyword->set_value($data['second_keyword'] ?? '')
                    ->set_is_second_keyword(true);
            }

            return $keyword;
        }

        private function get_rank_tracker($data)
        {
            $rank_tracker = new Aysa_Rank_Tracker();
            $rank_tracker->set_seo_data_id($data['seo_data_id'])
                ->set_keyword_id($data['keyword'])
                ->set_aysa_keyword_id($data['aysa_keyword_id']);

            return $rank_tracker;
        }

        public function get_entity_seo_data($entity_id, $type)
        {
            $seo_data = $this->seo_repository->get_entity_seo_data($entity_id, $type);

            if (!$seo_data) {
                throw new \Exception('Error getting seo data.');
            }

            $entity_data = json_decode(json_encode($seo_data), true);

            if ($seo_data->get_keyword_to_optimize_id()) {
                $entity_data['keyword'] = $this->keyword_repository->get_by_id($seo_data->get_keyword_to_optimize_id())->get_value();
            }

            if ($seo_data->get_second_keyword_id()) {
                $entity_data['second_keyword'] = $this->keyword_repository->get_by_id($seo_data->get_second_keyword_id())->get_value();
            }

            if ($type === 'product') {
                $product = wc_get_product($entity_id);
                $entity_data['name'] = $product->get_name();
                $entity_data['slug'] = $product->get_slug();
                $entity_data['description'] = $product->get_description();
                $entity_data['short_description'] = $product->get_short_description();
                $image_id = $product->get_image_id();
                if ($image_id) {
                    $entity_data['image']['url'] = wp_get_attachment_image_url($image_id, 'small');
                    $entity_data['image']['id'] = $image_id;
                }

                $image_gallery_id = $product->get_gallery_image_ids();
                foreach ($image_gallery_id as $id) {
                    $entity_data['image_gallery'][] = [
                        'url' => wp_get_attachment_image_url($id, 'small'),
                        'id' => $id
                    ];
                }
            }

            if ($type === 'category') {
                $category = get_term($entity_id, 'product_cat');
                $entity_data['name'] = $category->name;
                $entity_data['slug'] = $category->slug;
                $entity_data['description'] = $category->description;
                $image_id = get_term_meta($entity_id, 'thumbnail_id', true);
                if ($image_id) {
                    $entity_data['image']['url'] = wp_get_attachment_image_url($image_id, 'small');
                    $entity_data['image']['id'] = $image_id;
                }
            }

            return $entity_data;
        }
    }
}