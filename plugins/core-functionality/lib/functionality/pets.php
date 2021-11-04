<?php
/**
 * Core Functionality Plugin
 *
 * @package    CoreFunctionality
 * @since      1.0.0
 * @copyright  Copyright (c) 2014, Bill Erickson & Jared Atchison
 * @license    GPL-2.0+
 */

/**
 * The PetPoint XML API is an elusive beast.
 *
 * Once found, it's easy to wrangle however.
 * The DOCPAC PetPoint API key is:
 * m68gt285fxxj8g67hcw1b330o60squ4pgwmfrbuvi8uh0541ep
 *
 * Additional API information can be fount at:
 * http://www.petango.com/webservices/wsadoption.asmx
 */

/**
 * Pet listings
 *
 * @since 1.0.0
 */
function ja_pet_listing() {

	// Only run on dog and cat listing pages.
	if ( is_page( 'dogs' ) || is_page( 'cats' )  ) :

		if ( is_page( 'dogs' ) ) {
			$species       = '1';
			$species_label = 'dogs';
		} elseif ( is_page( 'cats' ) ) {
			$species       = '2';
			$species_label = 'cats';
		}

		//$cache = get_transient( 'pet_listing_' . $species_label );
		$cache = false;

		if ( false == $cache ) {

			// Fetch listing results
			$results = wp_remote_get( 'https://ws.petango.com/webservices/wsadoption.asmx/AdoptableSearch?authkey=m68gt285fxxj8g67hcw1b330o60squ4pgwmfrbuvi8uh0541ep&speciesID=' . $species . '&sex=&ageGroup=&location=&site=&onHold=&orderBy=&primaryBreed=&secondaryBreed=&specialNeeds=&noDogs=&noCats=&noKids=&stageID=', array( 'sslverify' => false ) );

			// Show error or results
			if ( is_wp_error( $results ) ) {

				// Error fetching results from API
				$error_message = $results->get_error_message();
				echo "There was an error finding the pet listings. Please try again shortly.";
				if ( is_super_admin() ) {
					echo "Error message: $error_message";
				}
				return;

			} else {

				// Results sucessfully fetched

				// Test debug to view raw XML below
				//echo '<pre>' . htmlspecialchars( print_r( $results['body'],true ) ) . '</pre>';

				// Thsi API uses XML instead of json so we do some trickery below to
				// reformat the results in a way we can better manipulate the data.
				$results = simplexml_load_string( $results['body'] );
				$results = json_encode( $results );
				$results = array_shift( json_decode( $results, TRUE ) );
				foreach ( $results as $key=>$result ) {
					$results[$key] = array_shift( $result );
				}

				// Set cache for 6 hours
				//set_transient( 'pet_listing_' . $species_label, $results, 3 * HOUR_IN_SECONDS );
			}
		} else {
			$results = $cache;
		}

		// Proceed to generate the listing index
		echo '<div class="pet-listings ' . $species_label . '">';

			$count   = 1;
			$results = array_filter( $results );

			foreach( $results as $result ) {

				$id    = esc_html( $result['ID'] );
				$photo = esc_url( str_replace( 'http://', 'https://' , $result['Photo'] ) );
                    $photo = str_replace( '_TN1', '', $photo ); // array only returns thumbnail image which has _TN1 at end of string. Remove this to show larger image
				$name  = esc_html( $result['Name'] );
				$sex   = esc_html( $result['Sex'] );
				$age   = esc_html( $result['Age'] );
				$breed = esc_html( $result['PrimaryBreed'] );
				$class = ( $count % 2 == 0 ? '' : 'first' );
				$sn    = $result['SN'];
				if ( is_array( $sn ) ) {
					$sn = array_shift( $sn );
				}
				$sn    = esc_html( trim( $sn ) );

				// Age adjustments
				if ( $age < 12 ) {
					$age = $age . ' months old';
				} else {
					$year = floor($age/12);
					$months = $age % 12;
					$age = $year . ' years';
					if ( 0 !== $months ) {
						$age .= ' '  . $months . ' months';
					}
					$age .= ' old';
				}

				echo '<div class="pet-listing one-half ' . $class . '">';
					echo '<a href="' . home_url( '/get-involved/adopt-an-animal/pet-details/?pid=' . $id ) . '"><img src="' . $photo . '"></a>';
					echo '<div class="details">';
						echo '<h4 class="name"><a href="' . home_url( '/get-involved/adopt-an-animal/pet-details/?pid=' . $id ) . '">' . $name . '</a></h4>';
						echo '<p class="breed">' . $breed . '</p>';
						echo '<p class="sex">';
							echo $sex;
							if ( !empty( $sn ) ) {
								echo ', ' . $sn;
							}
						echo '</p>';
						echo '<p class="age">' . $age . '</p>';
						echo '<a href="' . home_url( '/get-involved/adopt-an-animal/pet-details/?pid=' . $id ) . '" class="button button-small more-details">Details</a>';
					echo '</div>';
				echo '</div>';

				$count++;
			}

		echo '</div>';

	endif;
 }
 add_action( 'genesis_entry_content', 'ja_pet_listing', 20 );

/**
 * Get details of a specific pet.
 *
 * @param int $id
 * @return mixed false or array
 */
function ja_get_pet_listing_details( $id = '' ) {

	if ( empty( $id ) )
		return false;

	// Get / sanatize pet ID
	$pet_id = (int) $id;

	//$cache  = get_transient( 'pet_listing_' . $pet_id );
	$cache = false;

	if ( false == $cache ) {

		// Fetch listing results
		$results = wp_remote_get( 'https://ws.petango.com/webservices/wsadoption.asmx/AdoptableDetails?authkey=m68gt285fxxj8g67hcw1b330o60squ4pgwmfrbuvi8uh0541ep&animalID=' . $pet_id, array( 'sslverify' => false ) );

		// Show error or results
		if ( is_wp_error( $results ) ) {
			return false;
		} else {
			$results = simplexml_load_string( $results['body'] );
			$results = json_encode( $results );
			$results = json_decode( $results, TRUE );
			$results = ja_array_remove_empty( $results );
			// Set cache for 12 hours
			//set_transient( 'pet_listing_' . $pet_id, $results, 3 * HOUR_IN_SECONDS );
		}
	} else {
		$results = $cache;
	}

	return $results;
}

 /**
 * Pet listings Details
 *
 * @since 1.0.0
 */
function ja_pet_listing_details() {

	// Only run on pet detail/POTW pages
	if ( is_page( 'pet-details' ) || is_page( 'potw' ) ) {

		if ( is_page( 'potw' ) ) {
			$id = get_post_meta( get_the_id(), '_ja_pet_id', true );
			$results = ja_get_pet_listing_details( $id );
			$id2 = get_post_meta( get_the_id(), '_ja_pet2_id', true );
			$results2 = ja_get_pet_listing_details( $id2 );
		} else {
			$results = ja_get_pet_listing_details( $_GET['pid'] );
			$results2 = false;
		}

		// Dog

		if ( !$results ) {
			echo 'An error occured finding the dog pet listing.';
		} else {
			$id           = esc_html( $results['ID'] );
			$name         = esc_html( $results['AnimalName'] );
			$breed        = esc_html( $results['PrimaryBreed'] );
			$breed2       = esc_html( $results['SecondaryBreed'] );
			$sex          = esc_html( $results['Sex'] );
			$age          = esc_html( $results['Age'] );
			$spayed       = esc_html( $results['Altered'] );
			$size         = esc_html( $results['Size'] );
			$color        = esc_html( $results['PrimaryColor'] );
			$color2       = esc_html( $results['SecondaryColor'] );
			$declawed     = esc_html( $results['Declawed'] );
			$housetrained = esc_html( $results['Housetrained'] );
			$intake_date  = esc_html( $results['LastIntakeDate'] );
			$price        = esc_html( $results['Price'] );
			$photo1       = esc_url( str_replace( 'http://', 'https://' , $results['Photo1'] ) );
			$photo2       = esc_url( str_replace( 'http://', 'https://' , $results['Photo2'] ) );
			$photo3       = esc_url( str_replace( 'http://', 'https://' , $results['Photo3'] ) );
			$desc         = !empty( $results['Dsc'] ) ? esc_html( $results['Dsc'] ) : '';

			if ( is_super_admin() ) {
				//print_r( $results );
			}

			echo '<div class="pet-details">';

                    echo '<div class="pet-details__left">';

                         if ( !empty( $photo1 ) ) {
                              echo '<div class="pet-details-images">';
                                   echo '<img src="' . $photo1 . '" class="primary-photo">';
                                   if ( !empty( $photo2 ) ) {
                                        echo '<img src="' . $photo2 . '">';
                                   }
                                   if ( !empty( $photo3 ) ) {
                                        echo '<img src="' . $photo3 . '">';
                                   }
                              echo '</div>';
                         }

                         echo '<div class="pet-details__content">';

                              echo '<div class="pet-details__description">';
                                   echo wpautop( $desc );
                              echo '</div>';

                              echo '<div class="wp-block-buttons">';

                                   echo '<div class="wp-block-button has-small-font-size">';
                                        echo '<a class="wp-block-button__link has-white-color has-red-background-color has-text-color has-background" href="#">';
                                             echo 'Adopt Me';
                                        echo '</a>';
                                   echo '</div>';

                                   echo '<div class="wp-block-button has-small-font-size">';
                                        echo '<a class="wp-block-button__link has-white-color has-blue-background-color has-text-color has-background" href="#">';
                                             echo 'Sponsor Me';
                                        echo '</a>';
                                   echo '</div>';

                                   echo '<div class="wp-block-button is-style-inverse has-small-font-size">';
                                        echo '<a class="wp-block-button__link has-red-color has-red-background-color has-text-color has-background" href="#">';
                                             echo 'See Other Dogs';
                                        echo '</a>';
                                   echo '</div>';

                              echo '</div>';
                         echo '</div>';

                    echo '</div>';

                    echo '<div class="pet-details__right">';

                         echo '<h2 class="pet-details__name">' . $name . '</h2>';

                         echo '<div class="pet-details-meta">';

                              echo '<table class="table table-bordered">';
                                   echo '<tr>';
                                        echo '<td>Animal ID</td>';
                                        echo '<td>' . $id . '</td>';
                                   echo '</tr>';
                                   if ( !empty( $breed ) ) {
                                        echo '<tr>';
                                             echo '<td>Breed</td>';
                                             echo '<td>' . $breed;
                                             if ( !empty( $breed2 ) ) {
                                                  echo ', ' . $breed2;
                                             }
                                             echo '</td>';
                                        echo '</tr>';
                                   }
                                   if ( !empty( $age ) ) {
                                        if ( $age < 12 ) {
                                             $age = $age . ' months old';
                                        } else {
                                             $year = floor($age/12);
                                             $months = $age % 12;
                                             $age = $year . ' years';
                                             if ( 0 !== $months ) {
                                                  $age .= ' '  . $months . ' months';
                                             }
                                             $age .= ' old';
                                        }
                                        echo '<tr>';
                                             echo '<td>Age</td>';
                                             echo '<td>' . $age . '</td>';
                                        echo '</tr>';
                                   }
                                   if ( !empty( $sex ) ) {
                                        echo '<tr>';
                                             echo '<td>Sex</td>';
                                             echo '<td>' . $sex . '</td>';
                                        echo '</tr>';
                                   }
                                   if ( !empty( $size ) ) {
                                        echo '<tr>';
                                             echo '<td>Size</td>';
                                             echo '<td>';
                                             if ( 'S' == $size) {
                                                  echo 'Small';
                                             } elseif ( 'M' == $size ) {
                                                  echo 'Medium';
                                             } elseif ( 'L' == $size ) {
                                                  echo 'Large';
                                             } else {
                                                  echo $size;
                                             }
                                             echo  '</td>';
                                        echo '</tr>';
                                   }
                                   if ( !empty( $color ) ) {
                                        echo '<tr>';
                                             echo '<td>Color</td>';
                                             echo '<td>' . $color;
                                             if ( !empty( $color2 ) ) {
                                                  echo ', ' . $color2;
                                             }
                                             echo '</td>';
                                        echo '</tr>';
                                   }
                                   if ( !empty( $spayed ) ) {
                                        echo '<tr>';
                                             echo '<td>Spayed/Neutered</td>';
                                             echo '<td>' . $spayed . '</td>';
                                        echo '</tr>';
                                   }
                                   if ( !empty( $declawed ) ) {
                                        echo '<tr>';
                                             echo '<td>Declawed</td>';
                                             echo '<td>' . $declawed . '</td>';
                                        echo '</tr>';
                                   }
                                   if ( !empty( $housetrained ) ) {
                                        echo '<tr>';
                                             echo '<td>Housetrained</td>';
                                             echo '<td>' . $housetrained . '</td>';
                                        echo '</tr>';
                                   }
                                   if ( !empty( $intake_date ) ) {
                                        $intake_date = strtotime( $intake_date );
                                        echo '<tr>';
                                             echo '<td>Intake Date</td>';
                                             echo '<td>' . date( 'F j, Y', $intake_date ) . '</td>';
                                        echo '</tr>';
                                   }
                                   if ( !empty( $price ) ) {
                                        echo '<tr>';
                                             echo '<td>Adoption Price</td>';
                                             echo '<td>$' . $price . '</td>';
                                        echo '</tr>';
                                   }
                              echo '</table>';

                         echo '</div>';

                    echo '</div>';

			echo '</div>';
		}

		// Cat

		if ( !$results2  ) {
			if ( !is_page( 'pet-details' ) ) {
				echo 'An error occured finding the cat pet listing.';
			}
		} else {
			$id           = esc_html( $results2['ID'] );
			$name         = esc_html( $results2['AnimalName'] );
			$breed        = esc_html( $results2['PrimaryBreed'] );
			$sex          = esc_html( $results2['Sex'] );
			$age          = esc_html( $results2['Age'] );
			$spayed       = esc_html( $results2['Altered'] );
			$size         = esc_html( $results2['Size'] );
			$color        = esc_html( $results2['PrimaryColor'] );
			$color2       = esc_html( $results2['SecondaryColor'] );
			$declawed     = esc_html( $results2['Declawed'] );
			$housetrained = esc_html( $results2['Housetrained'] );
			$intake_date  = esc_html( $results2['LastIntakeDate'] );
			$price        = esc_html( $results2['Price'] );
			$photo1       = esc_url( $results2['Photo1'] );
			$photo2       = esc_url( $results2['Photo2'] );
			$photo3       = esc_url( $results2['Photo3'] );

			echo '<div class="pet-details" style="padding-top:20px;">';
				if ( !empty( $photo1 ) ) {
					echo '<div class="pet-details-images">';
						echo '<img src="' . $photo1 . '" class="primary-photo">';
						if ( !empty( $photo2 ) ) {
							echo '<img src="' . $photo2 . '">';
						}
						if ( !empty( $photo3 ) ) {
							echo '<img src="' . $photo3 . '">';
						}
					echo '</div>';
				}
				echo '<div class="pet-details-meta">';
					echo '<h2 class="name">' . $name . '</h2>';
					echo '<table class="table table-bordered">';
						echo '<tr>';
							echo '<td>Animal ID</td>';
							echo '<td>' . $id . '</td>';
						echo '</tr>';
						if ( !empty( $breed ) ) {
							echo '<tr>';
								echo '<td>Breed</td>';
								echo '<td>' . $breed . '</td>';
							echo '</tr>';
						}
						if ( !empty( $age ) ) {
							if ( $age < 12 ) {
								$age = $age . ' months old';
							} else {
								$year = floor($age/12);
								$months = $age % 12;
								$age = $year . ' years';
								if ( 0 !== $months ) {
									$age .= ' '  . $months . ' months';
								}
								$age .= ' old';
							}
							echo '<tr>';
								echo '<td>Age</td>';
								echo '<td>' . $age . '</td>';
							echo '</tr>';
						}
						if ( !empty( $sex ) ) {
							echo '<tr>';
								echo '<td>Sex</td>';
								echo '<td>' . $sex . '</td>';
							echo '</tr>';
						}
						if ( !empty( $size ) ) {
							echo '<tr>';
								echo '<td>Size</td>';
								echo '<td>';
								if ( 'S' == $size) {
								 	echo 'Small';
								} elseif ( 'M' == $size ) {
									echo 'Medium';
								} elseif ( 'L' == $size ) {
									echo 'Large';
								} else {
									echo $size;
								}
								echo  '</td>';
							echo '</tr>';
						}
						if ( !empty( $color ) ) {
							echo '<tr>';
								echo '<td>Color</td>';
								echo '<td>' . $color;
								if ( !empty( $color2 ) ) {
									echo ', ' . $color2;
								}
								echo '</td>';
							echo '</tr>';
						}
						if ( !empty( $spayed ) ) {
							echo '<tr>';
								echo '<td>Spayed/Neutered</td>';
								echo '<td>' . $spayed . '</td>';
							echo '</tr>';
						}
						if ( !empty( $declawed ) ) {
							echo '<tr>';
								echo '<td>Declawed</td>';
								echo '<td>' . $declawed . '</td>';
							echo '</tr>';
						}
						if ( !empty( $housetrained ) ) {
							echo '<tr>';
								echo '<td>Housetrained</td>';
								echo '<td>' . $housetrained . '</td>';
							echo '</tr>';
						}
						if ( !empty( $intake_date ) ) {
							$intake_date = strtotime( $intake_date );
							echo '<tr>';
								echo '<td>Intake Date</td>';
								echo '<td>' . date( 'F j, Y', $intake_date ) . '</td>';
							echo '</tr>';
						}
						if ( !empty( $price ) ) {
							echo '<tr>';
								echo '<td>Adoption Price</td>';
								echo '<td>$' . $price . '</td>';
							echo '</tr>';
						}
					echo '</table>';
				echo '</div>';
			echo '</div>';
		}
	}
}
add_action( 'genesis_before_entry_content', 'ja_pet_listing_details' );

/**
 * Helper function to remove blank array items
 *
 */
function ja_array_remove_empty($haystack) {
	foreach ($haystack as $key => $value) {
		if (is_array($value)) {
			$haystack[$key] = ja_array_remove_empty($haystack[$key]);
		} elseif (is_string($haystack[$key])) {
			$haystack[$key] = trim($value);
		}
		if (empty($haystack[$key])) {
			unset($haystack[$key]);
		}
	}
	return $haystack;
}
