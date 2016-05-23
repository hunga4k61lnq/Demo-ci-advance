
					<div class="col-md-2 col-md-pull-8 col-md-offset-0 col-sm-8 col-sm-offset-2 col-xs-12">
						<div class="category">
							<button><i class="fa fa-caret-right" aria-hidden="true"></i></button>
							<h3><i class="fa fa-align-left" aria-hidden="true"></i><?php echo lang('RECURMENT'); ?></h3>
							<ul>


							
						
								<!--DBS-loop.pro_categories.2|where:parent = 0, act =1, home =1|order:ord asc,id asc|limit:-->
									
								<li><a href="{(itempro_categories2.slug)}" title="{(itempro_categories2.name)}">{(itempro_categories2.name)}</a>								

									<ul>
									<!--DBS-loop.pro_categories.3|where:parent = $itempro_categories2['id'], act =1, home =1|order:ord asc,id asc|limit:-->
										<li><a href="#" title="">{(itempro_categories3.name)}</a></li>
										<!--DBE-loop.pro_categories.3-->
									</ul>

								</li>

								<!--DBE-loop.pro_categories.2-->
								
							</ul>
						</div>

						<div class="skype">
						<!--DBS-loop.support.4|where:act = 1,home = 1|order:ord asc,id asc|limit:0,1-->

											<a href="{(itemsupport4.link)}" title="{(itemsupport4.img)}">
												<img class="img-responsive" src="{(itemsupport4.img)}" alt="{(itemsupport4.name)}">
							</a>
							<!--DBE-loop.support.4-->

							<div class="skype-ct">

							<!--DBS-loop.support.5|where:act = 1,home = 1|order:ord asc,id asc|limit:-->

								<p><i class="glyphicon glyphicon-phone-alt"></i>{(itemsupport5.phone)}</p>
								<!--DBE-loop.support.5-->

								
							</div>
						</div>


					</div>